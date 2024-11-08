<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategorySeeder extends Seeder
{
    
    public function run(): void
    {
        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
        
        $ar_description = 'خسائر اللازمة ومطالبة حدة بل. الآخر الحلفاء أن غزو, إجلاء وتنامت عدد مع. لقهر معركة لبلجيكا، بـ انه, ربع الأثنان المقيتة في, اقتصّت المحور حدة و. هذه ما طرفاً عالمية استسلام, الصين وتنامت حين ٣٠, ونتج والحزب المذابح كل جوي. أسر كارثة المشتّتون بل, وبعض وبداية الصفحة غزو قد, أي بحث تعداد الجنوب.';

        $subcategories = [
            ['en' => 'Smart Outlet', 'ar' => 'المنافذ الذكية'],
            ['en' => 'Smart switch', 'ar' => 'التبديل الذكي'],
            ['en' => 'Earbuds', 'ar' => 'سماعات الأذن'],
            ['en' => 'Smart Screen', 'ar' => 'الشاشات الذكية'],
            ['en' => 'Smart lamp', 'ar' => 'المصباح الذكي'],
            ['en' => 'Smart module', 'ar' => 'الوحدة الذكية'],
            ['en' => 'Smart Dimmer', 'ar' => 'الباهتة الذكية'],
            ['en' => 'Smart thermostat', 'ar' => 'ترموستات ذكي'],
            ['en' => 'Outdoor lights', 'ar' => 'أضواء خارجية'],
            ['en' => 'Smart Meter', 'ar' => 'جهاز قياس ذكي'],
            ['en' => 'Smart Relay', 'ar' => 'التتابع الذكي'],
            ['en' => 'Smart speaker', 'ar' => 'السماعات الذكية'],
            ['en' => 'TV set', 'ar' => 'جهاز التلفاز'],
            ['en' => 'Projector', 'ar' => 'كشاف ضوئي'],
            ['en' => 'Smart Screen', 'ar' => 'الشاشة الذكية'],
            ['en' => 'Robot vacuum cleaner', 'ar' => 'روبوت المكنسة الكهربائية'],
            ['en' => 'TV', 'ar' => 'تلفاز'],
            ['en' => 'Smart Watches', 'ar' => 'ساعات ذكية'],
            ['en' => 'Blood pressure', 'ar' => 'قياس ضغط الدم'],
            ['en' => 'Smart scales', 'ar' => 'موازين ذكية'],
            ['en' => 'Thermostat', 'ar' => 'منظم الحراره'],
            ['en' => 'Hubs', 'ar' => 'محاور'],
            ['en' => 'Shutters module', 'ar' => 'وحدة مصاريع'],
            ['en' => 'Garage Doors', 'ar' => 'أبواب المرآب'],
            ['en' => 'Door Lock', 'ar' => 'قفل أبواب'],
            ['en' => 'Repeaters', 'ar' => 'إعادة الإرسال'],
            ['en' => 'Routers', 'ar' => 'راوتر'],
            ['en' => 'Controller', 'ar' => 'متحكم'],
            ['en' => 'Smart Tracker', 'ar' => 'متتبع ذكي'],
            ['en' => 'Video Doorbell', 'ar' => 'جرس الباب بالفيديو'],
            ['en' => 'Bridge', 'ar' => 'موصل'],
            ['en' => 'Keypad', 'ar' => 'لوحة مفاتيح'],
            ['en' => 'Indoor cameras', 'ar' => 'كاميرات مراقبة داخلية'],
            ['en' => 'Outdoor cameras', 'ar' => 'كاميرات مراقبة خارجية'],
            ['en' => 'Siren', 'ar' => 'سيرين'],
            ['en' => 'Motion sensor', 'ar' => 'حساس حركي'],
            ['en' => 'Window sensor', 'ar' => 'مستشعر النافذة'],
            ['en' => 'Smart Sensor', 'ar' => 'مستشعر ذكي'],
            ['en' => 'Water Sensor', 'ar' => 'مستشعر مياه'],
            ['en' => 'Smoke Sensor', 'ar' => 'مستشعر دخان'],
            ['en' => 'Home Alarm', 'ar' => 'جرس منزلي']
        ];

        $categories = Category::all();

        $usedSubcategories = [];

        foreach ($categories as $category) {

            $availableSubcategories = array_filter($subcategories, function ($subcategory) use ($usedSubcategories) {
                return !in_array($subcategory['en'], $usedSubcategories);
            });

            $selectedSubcategories = array_rand($availableSubcategories, min(3, count($availableSubcategories)));

            if (!is_array($selectedSubcategories)) {
                $selectedSubcategories = [$selectedSubcategories];
            }

            foreach ($selectedSubcategories as $index) {
                $subcategory = $availableSubcategories[$index];

                Subcategory::create([
                    'category_id' => $category->id,
                    'name' => $subcategory['en'],
                    'description' => $description,
                    'ar_name' => $subcategory['ar'],
                    'ar_description' => $ar_description,
                    'status' => 'active',
                ]);

                // Track the used subcategory name
                $usedSubcategories[] = $subcategory['en'];
            }
        }
    }
}
