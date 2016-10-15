<?php

use App\Models\FrontPage;
use App\Models\PageTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call('PageTemplateSeeder');
        Model::reguard();
    }
}


class PageTemplateSeeder extends Seeder
{
    public function run()
    {
        PageTemplate::create(['name' => 'p']);
        PageTemplate::create(['name' => 'programma']);
        PageTemplate::create(['name' => 'voorbereiden']);

        FrontPage::create([
            'name' => 'default',
            'blade_file' => 'frontpages.default',
            'active' => 1
        ]);
        FrontPage::create([
            'name' => 'event',
            'blade_file' => 'frontpages.event',
            'active' => 0
        ]);
        FrontPage::create([
            'name' => 'after',
            'blade_file' => 'frontpages.after',
            'active' => 0
        ]);
    }
}