<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Base extends Seeder
{

    //https: //codeigniter4.github.io/userguide/dbmgmt/seeds.html#
    //https: //iniblog.xyz/blogpost/article/87/seeder-and-faker#:~:text=To%20make%20a%20seeder%20in,App%2FMigrations%2FSeeds%20directory.&text=After%20the%20seeder%20created%2C%20choose,seeding%20into%20your%20database%20table.

    //https: //onlinewebtutorblog.com/concept-of-seeders-in-codeigniter-4-tutorial/

    public function run()
    {
        $this->call('TipoNominaSeeder');
        $this->call('AnioSeeder');
        $this->call('Tipouser');
        $this->call('Tipopercepcion');
        $this->call('Quincenas');
        $this->call('UserSeeder');
    }
}