<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {

        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $ar_description = 'خسائر اللازمة ومطالبة حدة بل. الآخر الحلفاء أن غزو, إجلاء وتنامت عدد مع. لقهر معركة لبلجيكا، بـ انه, ربع الأثنان المقيتة في, اقتصّت المحور حدة و. هذه ما طرفاً عالمية استسلام, الصين وتنامت حين ٣٠, ونتج والحزب المذابح كل جوي. أسر كارثة المشتّتون بل, وبعض وبداية الصفحة غزو قد, أي بحث تعداد الجنوب.';

        $brands = [
            'Apple', 'Google', 'DoorBird', 'POPP', 'Honor', 'Somfy', 'Eufy',
            'Aeotec', 'Fibaro', 'Heati', 'Ezviz', 'Nebula', 'Philio', 'Yale', 'Tp-Link',
            'Homey', 'Hikvsion', 'Tellur', 'Orvibo', 'NanoLeaf', 'Imou', 'Ariston', 'GoPro',
        ];

        foreach ($brands as $brandName) {
            Brand::create([
                'name' => $brandName,
                'description' => $description,
                'ar_description' => $ar_description,
            ]);
        }
    }
}
