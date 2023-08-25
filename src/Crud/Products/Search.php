<?php

declare(strict_types=1);

namespace App\Crud\Products;

use App\Database;
use App\Functions;
use App\WebPage;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

class Search
{
    public function __construct()
    {
        echo 'Search Product';
    }

    public static function execute(array $data): array
    {
        $results = [];
        $page = WebPage::init('Search Product', '/products/search');
        try {
            if (empty($data)) {
                throw new \Exception('All fields are required');
            }
            if (!isset($data['term'])) {
                throw new \Exception('Term is required');
            }
            array_map('trim', $data);
            $term = htmlspecialchars($data['term']);
            if (empty($term)) {
                throw new \Exception('The term is empty, please enter a valid term');
            }
            $words = explode(' ', $term);
            $iterations = 0;
            $omitTerms = [
                'a', 'an', 'the', 'and', 'or', 'but', 'nor', 'on', 'at', 'to', 'from', 'by', 'of', 'off', 'for', 'in',
                'out', 'over', 'with', 'as', 'el', 'la', 'los', 'las', 'y', 'o', 'u', 'de', 'del', 'al', 'a', 'ante',
                'bajo', 'cabe', 'con', 'contra', 'desde', 'en', 'entre', 'color'
            ];
            $connection = Database::connect();
            $sql = 'SELECT DISTINCT * FROM products WHERE ';
            foreach ($words as $word) {
                if ($iterations >= 10) {
                    continue;
                }
                if (in_array(trim($word), $omitTerms)) {
                    continue;
                }
                $sql .= 'LOWER(title) LIKE :word_' . $iterations . ' OR LOWER(description) LIKE :word_' . $iterations . ' OR ';
                $iterations++;
            }
            //$sql = substr($sql, 0, -3);
            $sql .= 'LOWER(title) LIKE :full_term OR LOWER(description) LIKE :full_term ';
            $sql .= 'ORDER BY id DESC';
            $statement = $connection->prepare($sql);
            $iterations = 0;
            foreach ($words as $word) {
                if ($iterations >= 10) {
                    continue;
                }
                if (in_array(trim($word), $omitTerms)) {
                    continue;
                }
                $statement->bindValue('word_' . $iterations, '%' . strtolower($word) . '%', \PDO::PARAM_STR);
                $iterations++;
            }
            $statement->bindValue('full_term', '%' . strtolower($term) . '%', \PDO::PARAM_STR);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $connection = null;
            Functions::createNotification('success', sprintf('Search results for: %s', $term));
        } catch (\Exception $e) {
            $page->getFramework()->error(sprintf('Error: %s', $e->getMessage()));
            Functions::createNotification('error', $e->getMessage());
        } catch (\PDOException $e) {
            $page->getFramework()->error(sprintf('Error: %s', $e->getMessage()));
            Functions::createNotification('error', "Server error");
        }
        return $results;
    }
}
