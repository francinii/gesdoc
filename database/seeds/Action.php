<?php

use Illuminate\Database\Seeder;

class Action extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Type 0 > It's for actions related to the flow
        //Type 1 >  It's for actions related to Documents
        //Type 2 > It's for the specific action begin (Beginning line in the flow)
        \DB::table('actions')->insert(array(
            'description' =>"Aceptar",
            'state' =>"Aceptado",
            'color'=> '#218838',
            'type' =>0,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Rechazar",
            'state' =>"Rechazado",
            'color'=> '#c82333',
            'type' =>0,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Inicio",
            'state' =>"Nuevo",
            'color'=> '#007bff', 
            'type' =>2,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Ver",
            'state' =>"Visto",
            'color' =>"#17a2b8",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Editar",
            'state' =>"Editado",
            'color'=> '#ffc107', 
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));

        \DB::table('actions')->insert(array(
            'description' =>"Compartir",
            'state' =>"Compartido",
            'color' =>"#6c757d",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Subir",
            'state' =>"Subido",
            'color' =>"#17a2b8",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Descargar",
            'state' =>"Descargado",
            'color' =>"#fd7e14",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Eliminar",
            'state' =>"Eliminado",
            'color' =>"#dc3545",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        
    }
}
