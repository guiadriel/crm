<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class PlanoDeContasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $planos = [
            [
                "name" => "Operacional",
                "subcategories" => [
                    "Professores",
                    "Auxiliar de Serviços Gerais",
                    "Uniformes",
                    "Transporte",
                    "Alimentação",
                    "Telefone",
                    "Aluguel/ IPTU",
                    "Água",
                    "Luz",
                    "Internet",
                    "Papelaria",
                    "Livros Alunos",
                    "Material de Limpeza",
                    "Material de Cozinha/ Padaria/ Lanche",
                    "Material de Consumo",
                    "Material e Equipamentos de Informática",
                ]
            ],
            [
                "name" => "Administrativo",
                "subcategories" => [
                    "Salário",
                    "Bonificação",
                    "Uniformes",
                    "Eventos",
                    "Transporte",
                    "Alimentação",
                    "Telefone",
                    "Material de Consumo",
                ]
            ],
            [
                "name" => "Comercial",
                "subcategories" => [
                    "Salário",
                    "Bonificação",
                    "Uniforme",
                    "Eventos",
                    "Transporte",
                    "Alimentação",
                    "Telefone",
                    "Material de Consumo",
                    "Materal Gráfico",
                    "Treinamento ",
                    "Propaganda",
                    "Parcerias",
                ]
            ],
            [
                "name" => "Administrador/Gerente/Coordenador",
                "subcategories" => [
                    "Salário",
                    "Bonificação",
                    "Uniforme",
                    "Eventos",
                    "Transporte",
                    "Alimentação",
                    "Telefone",
                    "Material de Consumo",
                    "Materal Gráfico",
                    "Prolabore",
                ]
            ],
            [
                "name" => "OUTROS CUSTOS VARIÁVEIS",
                "subcategories" => [
                    "Capital de Giro",
                    "Taxa bancária",
                ]
            ],
            [
                "name" => "IMPOSTOS",
                "subcategories" => []
            ],
            [
                "name" => "SERVIÇOS DE TERCEIROS",
                "subcategories" => [
                    "Contador",
                    "Serasa",
                    "Segurança",
                    "Manutenção Informática",
                    "Manutenção de Equipamentos",
                    "Manutenção Elétrica",
                    "Manutenção Ar Condicionado",
                    "Manutenção Predial",
                ]
            ],
            [
                "name" => "INVESTIMENTOS",
                "subcategories" => [
                    "Máquinas e Equipamentos",
                    "Empréstimos BNDES",
                ]
            ],
            [
                "name" => "Recebimento Cartão de Crédito",
                "subcategories" => [
                    "Matrícula",
                    "Material Didático",
                    "Mensalidade",
                    "RCC - Outros",
                ]
            ],
            [
                "name" => "Recebimento Cartão de Débito",
                "subcategories" => [
                    "Matrícula",
                    "Material Didático",
                    "Mensalidade",
                    "RCD - Outros",
                ]
            ],
            [
                "name" => "Recebimento Dinheiro",
                "subcategories" => [
                    "Matrícula",
                    "Material Didático",
                    "Mensalidade",
                    "Outros",
                ]
            ],
            [
                "name" => "Recebimento Boleto",
                "subcategories" => [
                    "Matrícula",
                    "Material Didático",
                    "Mensalidade",
                    "Outros",
                ]
            ]

        ];

        foreach($planos as $categoria){
            $category = Category::create([
                "name" => \mb_strtoupper($categoria['name'])
            ]);

            foreach($categoria['subcategories'] as $subCategory){
                SubCategory::create([
                    "category_id" => $category->id,
                    "name" => \mb_strtoupper($subCategory)
                ]);
            }
        }
    }
}
