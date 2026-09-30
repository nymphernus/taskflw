<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Deal;
use App\Models\Interaction;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['name' => 'Иван Петров', 'company' => 'ООО "Ромашка"', 'email' => 'ivan@romashka.ru', 'phone' => '+7 999 111-22-33'],
            ['name' => 'Мария Сидорова', 'company' => 'ИП Сидорова', 'email' => 'maria@sidorova.ru', 'phone' => '+7 999 222-33-44'],
            ['name' => 'Алексей Козлов', 'company' => 'ООО "Вектор"', 'email' => 'alexey@vector.ru', 'phone' => '+7 999 333-44-55'],
            ['name' => 'Елена Новикова', 'company' => 'Студия "Арт"', 'email' => 'elena@artstudio.ru', 'phone' => '+7 999 444-55-66'],
            ['name' => 'Дмитрий Волков', 'company' => 'ООО "СтройМонтаж"', 'email' => 'dmitry@stroymontazh.ru', 'phone' => '+7 999 555-66-77'],
            ['name' => 'Анна Кузнецова', 'company' => 'Бюро "Дизайн"', 'email' => 'anna@designbureau.ru', 'phone' => '+7 999 666-77-88'],
            ['name' => 'Сергей Морозов', 'company' => 'ООО "ТехноСофт"', 'email' => 'sergey@technosoft.ru', 'phone' => '+7 999 777-88-99'],
            ['name' => 'Ольга Павлова', 'company' => 'Агентство "Медиа"', 'email' => 'olga@mediaagency.ru', 'phone' => '+7 999 888-99-00'],
        ];

        foreach ($clients as $clientData) {
            Client::create($clientData);
        }

        $deals = [
            ['title' => 'Редизайн сайта', 'amount' => 150000, 'status' => 'in_progress'],
            ['title' => 'Мобильное приложение', 'amount' => 250000, 'status' => 'lead'],
            ['title' => 'SEO-продвижение', 'amount' => 50000, 'status' => 'paid'],
            ['title' => 'Интернет-магазин', 'amount' => 200000, 'status' => 'in_progress'],
            ['title' => 'Лендинг для акции', 'amount' => 30000, 'status' => 'lead'],
            ['title' => 'CRM-система', 'amount' => 180000, 'status' => 'rejected'],
            ['title' => 'Техническая поддержка', 'amount' => 25000, 'status' => 'paid'],
            ['title' => 'Рекламная кампания', 'amount' => 75000, 'status' => 'in_progress'],
            ['title' => 'Разработка логотипа', 'amount' => 15000, 'status' => 'paid'],
            ['title' => 'Онлайн-курс', 'amount' => 120000, 'status' => 'lead'],
            ['title' => 'Автоматизация отчётности', 'amount' => 90000, 'status' => 'in_progress'],
            ['title' => 'Дизайн интерьера', 'amount' => 220000, 'status' => 'lead'],
            ['title' => 'Создание контента', 'amount' => 40000, 'status' => 'paid'],
            ['title' => 'Внедрение 1С', 'amount' => 160000, 'status' => 'rejected'],
            ['title' => 'Аудит безопасности', 'amount' => 80000, 'status' => 'lead'],
        ];

        $clientIds = Client::pluck('id')->toArray();

        foreach ($deals as $dealData) {
            Deal::create([
                'client_id' => $clientIds[array_rand($clientIds)],
                'title'     => $dealData['title'],
                'amount'    => $dealData['amount'],
                'status'    => $dealData['status'],
            ]);
        }

        $interactionTypes = ['call', 'email', 'meeting', 'other'];
        $descriptions = [
            'Обсудили требования к проекту',
            'Отправили коммерческое предложение',
            'Провели встречу в офисе',
            'Уточнили сроки и бюджет',
            'Согласовали этапы работ',
            'Обсудили техническое задание',
            'Провели демонстрацию прототипа',
            'Согласовали дизайн-концепцию',
            'Обсудили условия оплаты',
            'Уточнили контактные данные',
        ];

        for ($i = 0; $i < 25; $i++) {
            Interaction::create([
                'client_id'   => $clientIds[array_rand($clientIds)],
                'type'        => $interactionTypes[array_rand($interactionTypes)],
                'description' => $descriptions[array_rand($descriptions)],
                'happened_at' => now()->subDays(rand(1, 30))->subHours(rand(0, 23)),
            ]);
        }

        $taskTitles = [
            'Подготовить коммерческое предложение',
            'Создать макет главной страницы',
            'Настроить аналитику',
            'Написать тексты для сайта',
            'Провести фотосессию',
            'Согласовать дизайн с клиентом',
            'Настроить приём платежей',
            'Протестировать формы обратной связи',
            'Опубликовать контент',
            'Провести аудит конкурентов',
            'Обновить прайс-лист',
            'Настроить рассылку',
        ];

        for ($i = 0; $i < 12; $i++) {
            $isOpen = $i < 6;
            Task::create([
                'client_id'   => $clientIds[array_rand($clientIds)],
                'title'       => $taskTitles[$i],
                'description' => 'Описание задачи: ' . $taskTitles[$i],
                'due_date'    => $isOpen ? now()->addDays(rand(1, 14)) : null,
                'status'      => $isOpen ? 'open' : 'done',
            ]);
        }
    }
}
