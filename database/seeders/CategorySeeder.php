<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Light and Energy' => 'الاضاءة والكهرباء',
            'Entertainments' => 'الترفيه',
            'Smart Security' => 'التأمين الذكي',
            'Smart Health' => 'الصحة الذكية',
            'Smart Appliances' => 'الأجهزة الذكية',
            'Connected Home' => 'المنازل المتصلة',
            'Connected Car' => 'السيارات المتصلة',
            'Outdoor & Garden' => 'الساحات الخارجية والحدائق',
            'EV charging' => 'شحن السيارة الكهربائية',
            'Solar energy' => 'الطاقة الشمسية',
        ];

        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $ar_description = 'خسائر اللازمة ومطالبة حدة بل. الآخر الحلفاء أن غزو, إجلاء وتنامت عدد مع. لقهر معركة لبلجيكا، بـ انه, ربع الأثنان المقيتة في, اقتصّت المحور حدة و. هذه ما طرفاً عالمية استسلام, الصين وتنامت حين ٣٠, ونتج والحزب المذابح كل جوي. أسر كارثة المشتّتون بل, وبعض وبداية الصفحة غزو قد, أي بحث تعداد الجنوب.';

        foreach ($categories as $enName => $arName) {
            Category::create([
                'name' => $enName,
                'description' => $description,
                'additional_description' => $description,
                'ar_name' => $arName,
                'ar_description' => $ar_description,
                'ar_additional_description' => $ar_description,
                'has_sub' => true,
            ]);
        }

    }
}
