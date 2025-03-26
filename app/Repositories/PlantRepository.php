<?php 
    namespace App\Repositories;

use App\DTO\Factories\PlantDtoFactory;
use App\DTO\Factories\PlantWithImageDtoFactory;
use App\DTO\PlantDto;
use App\DTO\PlantWithImageDto;
use App\Models\Plant;
    use App\Repositories\Interfaces\PlantRepositoryInterface;
use Database\Factories\PlantFactory;
use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Pagination\LengthAwarePaginator;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Storage;

    class PlantRepository implements PlantRepositoryInterface{

        public function all() : LengthAwarePaginator
        {
            return Plant::with('images')->paginate(10);
        }
        public function find(string $slug) : ?PlantWithImageDto
        {
            $plant = Plant::with('images')->where('slug', $slug)->first();
            return $plant ? PlantWithImageDtoFactory::fromModel($plant) : null; 
        }
        public function create(PlantWithImageDto $data) : PlantWithImageDto
        {
            DB::beginTransaction();
            try{
                $plant = Plant::create([
                    'name' => $data->name,
                    'price' => $data->price,
                    'category' => $data->category,
                    'description' => $data->description,
                    'admin_id' => $data->admin_id ?? Auth::id(),
                ]);
                if($data->images){
                    foreach($data->images as $image){
                        $path = $image->store('public/images');
                        $plant->images()->create([
                            'path' => Storage::url($path),
                            'title' => $plant->name,
                        ]);
                    }
                }
                DB::commit();
                return PlantWithImageDtoFactory::fromModel($plant->load('images'));
            }catch(\Exception $e){
                DB::rollBack();
                throw $e;
            }

        }
        public function update(string $slug, PlantWithImageDto $data) : ?PlantWithImageDto
        {
            $plant = Plant::where('slug',$slug)->first();
            
            if(!$plant){
                return null;
            }

            DB::beginTransaction();
            try{
                $plant->update([
                    'name' => $data->name,
                    'price' => $data->price,
                    'category' => $data->category,
                    'description' => $data->description,
                    'admin_id' => $data->admin_id ?? Auth::id(),
                ]);
                if($data->images){
                    $plant->images()->delete();
                    foreach($data->images as $image){
                        $path = $image->store('public/images');
                        $plant->images()->create([
                            'title' => $plant->name,
                            'path' => $path,
                        ]);
                    }
                }
                DB::commit();
                return PlantWithImageDtoFactory::fromModel($plant->load('images'));
            }catch(\Exception $e){
                DB::rollBack();
                throw $e;
            }

        }
        public function delete(string $slug) : bool
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