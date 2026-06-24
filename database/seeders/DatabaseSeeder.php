<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categorie;
use App\Models\Livre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Création de l'Admin
        User::create([
            'name' => 'Admin Bibliothèque',
            'email' => 'admin@bibliotheque.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Création de 3 Utilisateurs
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Étudiant $i",
                'email' => "user$i@bibliotheque.com",
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // 3. Création des 5 Catégories
        $categoriesData = [
            ['nom' => 'Informatique', 'description' => 'Développement, Réseaux et IA'],
            ['nom' => 'Mathématiques', 'description' => 'Algèbre, Analyse et Statistiques'],
            ['nom' => 'Gestion & Management', 'description' => 'Économie, Marketing et RH'],
            ['nom' => 'Littérature', 'description' => 'Romans, Poésie et Classiques'],
            ['nom' => 'Sciences', 'description' => 'Physique, Chimie et Biologie'],
        ];

        $categories = [];
        foreach ($categoriesData as $cat) {
            $categories[] = Categorie::create($cat);
        }

        // 4. Création des 20 Livres
        $livresData = [
            ['titre' => 'Maîtriser Laravel 11', 'auteur' => 'Jean Codeur', 'isbn' => '978-1-111', 'annee' => 2024, 'cat_index' => 0],
            ['titre' => 'Algorithmique Avancée', 'auteur' => 'Thomas Cormen', 'isbn' => '978-2-222', 'annee' => 2020, 'cat_index' => 0],
            ['titre' => 'Le Guide du Clean Code', 'auteur' => 'Robert C. Martin', 'isbn' => '978-3-333', 'annee' => 2019, 'cat_index' => 0],
            ['titre' => 'Introduction à la Cybersécurité', 'auteur' => 'Alice Sécu', 'isbn' => '978-4-444', 'annee' => 2022, 'cat_index' => 0],
            ['titre' => 'Algèbre Linéaire', 'auteur' => 'Henri Poincaré', 'isbn' => '978-5-555', 'annee' => 2015, 'cat_index' => 1],
            ['titre' => 'Probabilités et Statistiques', 'auteur' => 'Blaise Pascal', 'isbn' => '978-6-666', 'annee' => 2018, 'cat_index' => 1],
            ['titre' => 'Calcul Différentiel', 'auteur' => 'Isaac Newton', 'isbn' => '978-7-777', 'annee' => 2017, 'cat_index' => 1],
            ['titre' => 'Mathématiques Discrètes', 'auteur' => 'Alan Turing', 'isbn' => '978-8-888', 'annee' => 2021, 'cat_index' => 1],
            ['titre' => 'Principes de Marketing', 'auteur' => 'Philip Kotler', 'isbn' => '978-9-999', 'annee' => 2020, 'cat_index' => 2],
            ['titre' => 'Gestion de Projet Agile', 'auteur' => 'Eric Ries', 'isbn' => '978-1-010', 'annee' => 2023, 'cat_index' => 2],
            ['titre' => 'Comptabilité Générale', 'auteur' => 'Pierre Dupont', 'isbn' => '978-1-121', 'annee' => 2021, 'cat_index' => 2],
            ['titre' => 'Management des Organisations', 'auteur' => 'Michael Porter', 'isbn' => '978-1-313', 'annee' => 2019, 'cat_index' => 2],
            ['titre' => 'Les Misérables', 'auteur' => 'Victor Hugo', 'isbn' => '978-1-414', 'annee' => 1862, 'cat_index' => 3],
            ['titre' => 'L Étranger', 'auteur' => 'Albert Camus', 'isbn' => '978-1-515', 'annee' => 1942, 'cat_index' => 3],
            ['titre' => '1984', 'auteur' => 'George Orwell', 'isbn' => '978-1-616', 'annee' => 1949, 'cat_index' => 3],
            ['titre' => 'Le Petit Prince', 'auteur' => 'Antoine de Saint-Exupéry', 'isbn' => '978-1-717', 'annee' => 1943, 'cat_index' => 3],
            ['titre' => 'Relativité Générale', 'auteur' => 'Albert Einstein', 'isbn' => '978-1-818', 'annee' => 1916, 'cat_index' => 4],
            ['titre' => 'Une brève histoire du temps', 'auteur' => 'Stephen Hawking', 'isbn' => '978-1-919', 'annee' => 1988, 'cat_index' => 4],
            ['titre' => 'Origine des Espèces', 'auteur' => 'Charles Darwin', 'isbn' => '978-2-020', 'annee' => 1859, 'cat_index' => 4],
            ['titre' => 'Chimie Organique', 'auteur' => 'Marie Curie', 'isbn' => '978-2-121', 'annee' => 2020, 'cat_index' => 4],
        ];

        foreach ($livresData as $livre) {
            Livre::create([
                'titre' => $livre['titre'],
                'auteur' => $livre['auteur'],
                'isbn' => $livre['isbn'],
                'annee' => $livre['annee'],
                'categorie_id' => $categories[$livre['cat_index']]->id,
            ]);
        }
    }
}