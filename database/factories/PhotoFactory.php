<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'picture' => $this->getImage(rand(1,4))
        ];
    }
    public function getImage($image_number): string
    {
        $path = storage_path() . "/seed_pictures/" . $image_number . ".jpg";
        $image_name = md5($path) . '.jpg';
        $resize = Image::make($path)->fit(300)->encode('jpg');
        Storage::disk('public')->put('pictures/'.$image_name, $resize->__toString());
        return 'pictures/'.$image_name;
    }
}
