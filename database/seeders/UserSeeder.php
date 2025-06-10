<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Capturar possíveis exceções durante a execução do seeder. 
        try {

            // Se não encontrar o registro com o e-mail, cadastra o registro no BD
            User::firstOrCreate(
                ['email' => 'cesar@celke.com.br'],
                [
                    'name' => 'Cesar',
                    'email' => 'cesar@celke.com.br',
                    'password' => '123456A#',
                    'date_of_birth' => Carbon::now()->subYears(30),
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis ratione necessitatibus consequatur quas autem temporibus tenetur accusamus, voluptas nisi expedita sit quo adipisci, iste esse quasi a laborum excepturi nesciunt.',
                ],
            );

            User::firstOrCreate(
                ['email' => 'kelly@celke.com.br'],
                [
                    'name' => 'Kelly',
                    'email' => 'kelly@celke.com.br',
                    'password' => '123456A#',
                    'date_of_birth' => Carbon::now()->subYears(30)->subDays(5),
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis ratione necessitatibus consequatur quas autem temporibus tenetur accusamus, voluptas nisi expedita sit quo adipisci, iste esse quasi a laborum excepturi nesciunt.',
                ],
            );

            User::firstOrCreate(
                ['email' => 'jessica@celke.com.br'],
                [
                    'name' => 'Jessica',
                    'email' => 'jessica@celke.com.br',
                    'password' => '123456A#',
                    'date_of_birth' => Carbon::now()->subYears(30)->subDays(10),
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis ratione necessitatibus consequatur quas autem temporibus tenetur accusamus, voluptas nisi expedita sit quo adipisci, iste esse quasi a laborum excepturi nesciunt.',
                ],
            );

            User::firstOrCreate(
                ['email' => 'gabrielly@celke.com.br'],
                [
                    'name' => 'Gabrielly',
                    'email' => 'gabrielly@celke.com.br',
                    'password' => '123456A#',
                    'date_of_birth' => Carbon::now()->subYears(30)->subDays(15),
                    'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis ratione necessitatibus consequatur quas autem temporibus tenetur accusamus, voluptas nisi expedita sit quo adipisci, iste esse quasi a laborum excepturi nesciunt.',
                ],
            );
        } catch (Exception $e) {

            Log::notice('Usuário não cadastro.', ['error' => $e->getMessage()]);
        }
    }
}
