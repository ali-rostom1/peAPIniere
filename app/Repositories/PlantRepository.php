<?php 
    namespace App\Repositories;

use App\Models\Plant;
use App\Repositories\Interfaces\PlantRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

    class PlantRepository implements PlantRepositoryInterface{

        public function all() : LengthAwarePaginator
        {
            return Plant::with('images')->paginate(10);
        }
        public function find(string $slug)
        {
            return Plant::with('images')->where('slug',$slug)->first();
        }
        public function create(array $data,array $uploadedImages)
        {
            DB::beginTransaction();
            try{
                $plant = Plant::create([
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'category' => $data['category'],
                    'description' => $data['description'],
                    'admin_id' => $data['admin_id'],
                ]);
                if($uploadedImages){
                    foreach($uploadedImages as $image){
                        $path = $image->store('public/images');
                        $plant->images()->create([
                            'path' => Storage::url($path),
                            'title' => $plant->title,
                        ]);
                    }
                }
                DB::commit();
                return $plant->load('images');
            }catch(\Exception $e){
                DB::rollBack();
                throw $e;
            }

        }
        public function update(string $slug, array $data,array $uploadedImages)
        {
            $plant = Plant::where('slug',$slug)->first();
            
            if(!$plant){
                return null;
            }

            DB::beginTransaction();
            try{
                $plant->update([
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'category' => $data['category'],
                    'description' => $data['description'],
                    'admin_id' => $data['admin_id'],
                ]);
                if($uploadedImages){
                    $plant->images()->delete();
                    foreach($uploadedImages as $image){
                        $path = $image->store('public/images');
                        $plant->images()->create([
                            'name' => $plant->name,
                            'path' => $path,
                        ]);
                    }
                }
                DB::commit();
                return $plant->load('images');
            }catch(\Exception $e){
                DB::rollBack();
                throw $e;
            }

        }
        public function delete(string $slug)
        {
            $plant = Plant::where('slug',$slug)->first();
            if($plant){
                $plant->images()->delete();
                $plant->delete();
                return true;
            }else{
                return false;
            }
        }

    }