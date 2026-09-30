<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CrmDemoSeeder extends Seeder
{
     public function run(): void
    {
        // 1. Crear 3 asesores
        $asesores = [];
        foreach (['Ana Rodríguez', 'Carlos Pérez', 'María González'] as $name) {
            $asesores[] = [
                'name'  => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@crm.com',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('users')->insert($asesores);
        // 2. Crear 15 clientes distribuidos por zonas y asesores
        $zonas     = ['Oeste', 'Este', 'Cabudare', 'Centro', 'Zona Industrial'];
        $empresas  = [
            'Distribuidora Lara C.A.', 'Tecnoservicios Barquisimeto',
            'Ferretería El Tornillo', 'Panificadora La Espiga',
            'Auto Repuestos Central', 'Farmacia Salud Total',
            'Comercial Los Andes', 'Servicios Técnicos Zulia',
            'Inversiones Barquisimeto', 'Textiles del Centro',
            'Alimentos del Este', 'Logística Express Lara',
            'Constructora Occidente', 'Repuestos Cabudare', 'Mini Market 24'
        ];
        $clientes = [];
        foreach ($empresas as $i => $empresa) {
            $clientes[] = [
                'nombre_empresa'     => $empresa,
                'contacto_principal' => 'Contacto ' . ($i + 1),
                'telefono_whatsapp'  => '58414' . str_pad(rand(1000000, 9999999), 7, 
'0', STR_PAD_LEFT),
                'zona_geografica'    => $zonas[$i % 5],
                'user_id'            => ($i % 3) + 1,
                'origin_id'          => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ];
        }
        DB::table('clients')->insert($clientes);
        // 3. Crear interacciones (3-6 por cliente)
        $tipos    = ['Llamada', 'Visita', 'WhatsApp'];
        $clients  = DB::table('clients')->get();
        foreach ($clients as $client) {
            foreach (range(1, rand(3, 6)) as $j) {
DB::table('interactions')->insert([
'client_id'
         => 
$client->id,
'tipo_interaccion'  => $tipos[array_rand($tipos)],
'observaciones'
     => 
'Seguimiento #' . $j,
'fecha_seguimiento' => now()->subDays(rand(1, 60)),
'created_at'
        => 
'updated_at'
]);
}
$this->command->info('
✅
 CRM poblado: 3 asesores, 15 clientes, 
interacciones.');
}
}
}
