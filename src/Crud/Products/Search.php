<?php

declare(strict_types=1);

namespace App\Crud\Products;

use App\Core\{Application, Database};
use App\Helpers\Functions;

require_once dirname(__DIR__) . '/../../vendor/autoload.php';

/**
 * Search class
 *
 * This class provides a static method to execute a search query on the products table.
 * The search query is performed based on the given search term.
 * The search term is split into words and each word is used to search for matches in the title and description columns of the products table.
 * The search results are returned as an array of associative arrays, where each associative array represents a row in the products table.
 * If an error occurs during the search, an exception is thrown and an error notification is created.
 *
 * @package App\Crud\Products
 *
 */
class Search
{
    /**
     * Executes a search for products based on the given data.
     *
     * @param array $data An array containing the search term.
     *
     * @throws \Exception If all fields are required or if the term is empty.
     * @throws \PDOException If there is a server error.
     *
     * @return array An array containing the search results.
     *
     */
    public static function execute(array $data): array
    {
        $results = [];
        $page = Application::init('Search Product', '/products/search');
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
            // This array contains the terms that will be omitted from the search.
            $omitTerms = [
                'a', 'an', 'the', 'and', 'or', 'but', 'nor', 'on', 'at', 'to', 'from', 'by', 'of', 'off', 'for', 'in',
                'out', 'over', 'with', 'as', 'el', 'la', 'los', 'las', 'y', 'o', 'u', 'de', 'del', 'al', 'a', 'ante',
                'bajo', 'cabe', 'con', 'contra', 'desde', 'en', 'entre', 'color'
            ];
            $connection = Database::connect();
            // Construct the SQL statement for each word in the search term.
            // The SQL statement is constructed dynamically based on the number of words in the search term.
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
