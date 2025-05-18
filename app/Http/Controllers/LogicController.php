<?php
namespace App\Http\Controllers;

use App\Models\FamilyMember;
use App\Models\FamilyTree;
use Illuminate\Http\Request;

class LogicController extends Controller
{
    public function compare(Request $request)
    {
        $tree_id = $request->input('tree_id');
    
        $person1 = FamilyMember::where('name', $request->name1)
                    ->where('tree_id', $tree_id)->first();
    
        $person2 = FamilyMember::where('name', $request->name2)
                    ->where('tree_id', $tree_id)->first();
    
        if (!$person1 || !$person2) {
            return back()->with('error', 'Anggota keluarga tidak ditemukan.');
        }
        //untuk person1 -> person 2
        $visited = [];
        $path = [];
        $found = $this->dfs($person1, $person2->id, $visited, $path);
    
        $relationshipDetails = $found
            ? $this->relationshipPath($path, $person1->name, $person2->name)
            : 'Tidak ada hubungan yang ditemukan.';

        //Reverse person 2 -> person 1
        $visitedReverse = [];
        $pathReverse = [];
        $foundReverse = $this->dfs($person2, $person1->id, $visitedReverse, $pathReverse);

        $relationshipDetailsReversed = $foundReverse
            ? $this->relationshipPath($pathReverse, $person2->name, $person1->name)
            : 'Tidak ada hubungan yang ditemukan.';
    
        $tree = FamilyTree::find($tree_id);
        $members = FamilyMember::where('tree_id', $tree_id)->get();
        $rootMembers = $members->whereNull('parent_id');
    
        return view('compare', compact(
            'tree_id', 'tree', 'members', 'rootMembers',
            'person1', 'person2', 'relationshipDetails', 'relationshipDetailsReversed',
            'path','pathReverse' 
        ));
    }

    

    

    public function dfs($current, $targetId, &$visited, &$path)
    {
        if (in_array($current->id, $visited)) return false;
    
        $visited[] = $current->id;
        $path[] = $current;
    
        if ($current->id == $targetId) return true;
    
        // Cek ke atas
        if ($current->parent) {
            if ($this->dfs($current->parent, $targetId, $visited, $path)) return true;
        }
    
        // Cek ke bawah
        foreach ($current->children as $child) {
            if ($this->dfs($child, $targetId, $visited, $path)) return true;
        }
    
        // Cek ke samping 
        if ($current->parent) {
            foreach ($current->parent->children as $sibling) {
                if ($sibling->id != $current->id) {
                    if ($this->dfs($sibling, $targetId, $visited, $path)) return true;
                }
            }
        }
    
        array_pop($path);
        return false;
    }


    public function bfs($start, $targetId)
    {
        $queue = [[$start, [$start]]];
        $visited = [$start->id => true];
    
        while (!empty($queue)) {
            [$current, $path] = array_shift($queue);
    
            if ($current->id == $targetId) {
                return $path;
            }
    
            // Tambahkan anak
            foreach ($current->children as $child) {
                if (!isset($visited[$child->id])) {
                    $visited[$child->id] = true;
                    $queue[] = [$child, array_merge($path, [$child])];
                }
            }
    
            // Tambahkan parent
            if ($current->parent && !isset($visited[$current->parent->id])) {
                $visited[$current->parent->id] = true;
                $queue[] = [$current->parent, array_merge($path, [$current->parent])];
            }
    
            // Tambahkan saudara kandung
            if ($current->parent) {
                foreach ($current->parent->children as $sibling) {
                    if ($sibling->id !== $current->id && !isset($visited[$sibling->id])) {
                        $visited[$sibling->id] = true;
                        $queue[] = [$sibling, array_merge($path, [$sibling])];
                    }
                }
            }
        }
    
        return null;
    }
    

    public function getAncestor(FamilyMember $person, int $levels): ?FamilyMember
    {
        $node = $person;
        for ($i = 0; $i < $levels; $i++) {
            if (! optional($node->parent)->id) {
                return null;
            }
            $node = $node->parent;
        }
        return $node;
    }

    // HASIL HUBUNGAN
    public function relationshipResult($path) //ngaruh di hasil hubungan
    {
        $depth       = $this->calculateActualDepth($path);
        $first       = $path[0];
        $last        = end($path);
        $gender      = $first->gender;
        
        

        $relations = [
            -1 => ['Laki-Laki' => 'anak laki laki ', 'Perempuan' => 'anak perempuan '],
            1 => ['Laki-Laki' => 'bapak dari', 'Perempuan' => 'ibu dari'],
            2 => ['Laki-Laki' => 'putu lanang (cucu laki-laki) dari', 'Perempuan' => 'putu wedok (cucu perempuan) dari'],
            -2 => ['Laki-Laki' => 'eyang lanang (kakek) ', 'Perempuan' => 'eyang wedok (nenek) '],
            -3 => ['Laki-Laki' => 'mbah buyut lanang ', 'Perempuan' => 'mbah buyut wedok '],
            3 => ['Laki-Laki' => 'cicit/buyut lanang dari',  'Perempuan' => 'cicit/buyut wedok dari'],
            -4 => ['Laki-Laki' => 'mbah canggah lanang ',  'Perempuan' => 'mbah canggah wedok '],
            4 => ['Laki-Laki' => 'canggah lanang dari', 'Perempuan' => 'canggah wedok dari'],
            -5 => ['Laki-Laki' => 'mbah wareg lanang dari', 'Perempuan' => 'mbah wareg wedok dari'],
            5 => ['Laki-Laki' => 'wareg lanang dari', 'Perempuan' => 'wareg wedok dari'],
            -6 => ['Laki-Laki' => 'mbah uthek-uthek lanang dari', 'Perempuan' => 'mbah uthek-uthek wedok dari'],
            6 => ['Laki-Laki' => 'uthek-uthek lanang dari', 'Perempuan' => 'uthek-uthek wedok dari'],
            -7 => ['Laki-Laki' => 'mbah gantung siwur lanang dari', 'Perempuan' => 'mbah gantung siwur wedok dari'],
            7 => ['Laki-Laki' => 'gantung siwur lanang dari', 'Perempuan' => 'gantung siwur wedok dari'],
            -8 => ['Laki-Laki' => 'mbah gropak santhe lanang dari', 'Perempuan' => 'mbah gropak santhe wedok dari'],
            8 => ['Laki-Laki' => 'cicip moning lanang dari', 'Perempuan' => 'cicip moning wedok dari'],
            -9 => ['Laki-Laki' => 'mbah debog bosok lanang dari', 'Perempuan' => 'mbah debog bosok wedok dari'],
            9 => ['Laki-Laki' => 'petarang bobrok lanang dari', 'Perempuan' => 'petarang bobrok wedok dari'],
            -10 => ['Laki-Laki' => 'mbah galih asem lanang dari', 'Perempuan' => 'mbah galih asem wedok dari'],
            10 => ['Laki-Laki' => 'gropak santhe lanang dari', 'Perempuan' => 'gropak santhe wedok dari'],
            'nak-sanak' => [ 'Laki-Laki' => 'sedulur nak-sanak lanang (sepupu) dengan', 'Perempuan' => 'sedulur nak-sanak wedok (sepupu) dengan'],
            'misanan' => ['Laki-Laki' => 'sedulur misanan lanang (sepupu) dengan',  'Perempuan' => 'sedulur misanan wedok (sepupu) dengan'],
            'mindhoan' => ['Laki-Laki' => 'sedulur mindhoan lanang (sepupu) dengan', 'Perempuan' => 'sedulur mindhoan wedok (sepupu) dengan'],
            'old uncle' => ['Laki-Laki' => 'pakde dari',  'Perempuan' => 'bukde dari'],
            'young uncle' => ['Laki-Laki' => 'paklek dari', 'Perempuan' => 'buklek dari'],
            'ponakan prunan' => ['Laki-Laki' => 'ponakan prunan lanang dari', 'Perempuan' => 'ponakan prunan wedok dari'],
            'ponakan' => ['Laki-Laki' => 'ponakan lanang dari','Perempuan' => 'ponakan wedok dari']
            
        ];


        //LOGIC NYA   
        // 1. Orang tua langsung
        if ($last->parent_id === $first->id) {
            return $relations[1][$gender]. " {$last->name}" ;
        }

        // 2. Anak langsung
        if ($first->parent_id === $last->id) {
            $urutan = $first->urutan;
            return $relations[-1][$gender] . " ke-{$urutan} {$last->name}";
        }

        // 3. Saudara kandung
        if ($depth === 0 && $first->parent_id === $last->parent_id) {
            if ($first->urutan < $last->urutan) {
                return ($first->gender === 'Laki-Laki' ? 'mas dari' : 'mbak dari')." {$last->name}" ;
            }
            return ($first->gender === 'Laki-Laki' ? 'adik laki-laki dari' : 'adik perempuan dari')." {$last->name}";
        }

        // 4. Sepupu  (nak-sanak)
        if ($depth === 0 && optional($first->parent)->parent_id
            && optional($last->parent)->parent_id
            && $first->parent->parent_id === $last->parent->parent_id) {
            $grandf = $first->parent->parent; //mencari kakek/nenek
            $grandfgender = $relations[-2][$grandf->gender]; 
            return $relations['nak-sanak'][$gender] . " {$last->name} dari {$grandfgender}  {$grandf->name}";
        }
       

        // 5.  (misanan)
        if ($depth === 0 && optional($first->parent->parent)->parent_id
            && optional($last->parent->parent)->parent_id
            && $first->parent->parent->parent_id === $last->parent->parent->parent_id) {
            $buyut = $first->parent->parent->parent;
            $buyutgender = $relations[-3][$buyut->gender];
            return $relations['misanan'][$gender]. " {$last->name} dari {$buyutgender} {$buyut->name}";
        }
        // 6. Mindhoan
        if ($depth === 0 && optional($first->parent->parent->parent)->parent_id
            && optional($last->parent->parent->parent)->parent_id
            && $first->parent->parent->parent->parent_id === $last->parent->parent->parent->parent_id) {
            $canggah = $first->parent->parent->parent->parent;
            $canggahgender = $relations[-4][$canggah->gender];
            return $relations['mindhoan'][$gender]. " {$last->name} dari {$canggahgender} {$canggah->name}";
        }

        // 7. Pakde/paklek
        if ($depth === -1 && optional($last->parent)->parent_id
            && $first->parent_id === $last->parent->parent_id) {
            $key = $first->urutan < $last->parent->urutan ? 'old uncle' : 'young uncle';
            return $relations[$key][$first->gender]." {$last->name}";
        }

        // 8. Keponakan 
        if ($depth === 1 && isset($first->parent)
            && $last->parent_id === $first->parent->parent_id) {
            $key = $last->urutan < $first->parent->urutan ? 'ponakan prunan' : 'ponakan';
            return $relations[$key][$gender]." {$last->name}";
        }

        // 9. Cucu 
        if ($depth === 2 && $last->parent   && $last->parent->parent ) {
            return $relations[2][$gender]. " {$last->name}";
        }

        // 10. Kakek/Nenek 
        if ($depth === -2 && $last->parent && $last->parent->parent) {
            return $relations[-2][$gender]. " {$last->name}";
        }

        //  A. Aunt/Uncle once‐removed (dan lebih)
        if ($depth < 0) {
            // removed = 0 → direct uncle, 1 → once-removed, 2 → twice-removed
            $removed     = abs($depth) - 1;
            $pFirst      = $this->getAncestor($first, 1);            // ayah/ibu first
            $commonAnc   = $this->getAncestor($last, $removed + 2);  // ancestor di level yang sama

            if ($pFirst && $commonAnc && $pFirst->parent_id === $commonAnc->parent_id
            ) {
                $u1  = $pFirst->urutan;
                $u2  = optional($commonAnc)->urutan; 
                $key = ($u1 !== null && $u2 !== null && $u1 < $u2) ? 'old uncle' : 'young uncle';
                return $relations[$key][$first->gender]." {$last->name}";
            }
        }

        // test commit

        // test cimmit 2

        //  Niece/Nephew once‐removed (dan lebih)
        if ($depth > 0) {
            // removed = 0 → direct niece, 1 → once-removed, 2 → twice-removed
            $removed     = $depth - 1;
            $pLast       = $this->getAncestor($last, 1);              // ayah/ibu last
            $commonAnc   = $this->getAncestor($first, $removed + 2);  // ancestor level yang sama

            if ($pLast && $commonAnc && $pLast->parent_id === $commonAnc->parent_id
            ) {
                $u1  = optional($commonAnc)->urutan;
                $u2  = optional($pLast)->urutan;  
                $key = ($u1 !== null && $u2 !== null && $u1 < $u2) ? 'ponakan prunan' : 'ponakan';
                return $relations[$key][$first->gender]." {$last->name}";
            }
        }



        // Default fallback
        return $relations[$depth][$gender] ?? 'saudara jauh';
    }

    // JALUR HUBUNGAN
    public function relationshipPath($path, $firstPersonName, $secondPersonName) 
    {
        $path = array_reverse($path);
        $firstPerson = $path[0]->name;
        $lastPerson = end($path)->name;

        if ($firstPerson !== $firstPersonName) {
            $path = array_reverse($path);
            $firstPerson = $firstPersonName;
            $lastPerson = $secondPersonName;
        }


        $relationshipDescription = $this->relationshipResult($path);
        $detailedPath = [];

        for ($i = 0; $i < count($path) - 1; $i++) {
            $current = $path[$i];
            $next = $path[$i + 1];
        
            // 1. cek orang tua anak
            if ($next->parent_id == $current->id) {
                $relation = ($next->gender == 'Laki-Laki') ? "putra (anak laki-laki) " : "putri (anak perempuan) ";
                $detailedPath[] = " {$next->name} {$relation}ke-{$next->urutan} dari {$current->name}";
                continue;
            }
            // 2. cek orang tua anak (reverse)
            elseif ($current->parent_id == $next->id) {
                $relation = ($current->gender == 'Laki-Laki') ? "putra (anak laki-laki) " : "putri (anak perempuan) ";
                $detailedPath[] = " {$current->name} {$relation}ke-{$current->urutan} dari {$next->name}";
                continue;
            }

            // 3. cek saudara kandung
            if ($current->parent_id === $next->parent_id) {
                if ($current->urutan < $next->urutan) {
                    // current lebih tua → kakak
                    $role = $current->gender === 'Laki-Laki' ? 'mas' : 'mbak';
                } else {
                    // current lebih muda → adik
                    $role = $current->gender === 'Laki-Laki'
                        ? 'adik laki-laki'
                        : 'adik perempuan';
                }
                $detailedPath[] = " {$current->name} {$role} dari {$next->name}";
                continue;
            }
         
        }

        return [
            'relation' => "{$firstPerson} {$relationshipDescription} ",
            'detailedPath' => $detailedPath
        ];
    }

    protected function calculateActualDepth($path)
    {
        if (count($path) < 2) return 0;

        $depth = 0;
        $current = $path[0];

        for ($i = 1; $i < count($path); $i++) {
            $next = $path[$i];
            
            if ($next->parent_id == $current->id) {
                $depth--;
            } elseif ($current->parent_id == $next->id) {
                $depth++;
            }
            
            $current = $next;
        }

        return $depth;
    }
    

}




