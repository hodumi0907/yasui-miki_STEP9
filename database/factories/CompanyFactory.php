<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'company_name' => $this -> faker -> company, //ランダムな文を会社名として生成
            'street_address' => $this -> faker -> streetAddress, //ランダムな文を会社名として生成
            'representative_name' => $this -> faker -> name, //ランダムな文を会社名として生成
            //created_at と updated_at はEloquentが自動的に処理するので、追加不要。
        ];
    }
}
