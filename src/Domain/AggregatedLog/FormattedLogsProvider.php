<?php

namespace Domain\AggregatedLog;
/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 14.11.19
 * Time: 17:17
 */
class FormattedLogsProvider
{
    /**
     * @var \DB\DBConnectionInterface
     */
    private $connection;


    /**
     * FormattedLogsProvider constructor.
     */
    public function __construct(\DB\DBConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function retrieveFormattedLogs(
        \DateTimeImmutable $from,
        \DateTimeImmutable $to,
        string $countryId = null,
        string $userId = null
    ): array
    {
        if ($countryId) {
            $numbers   = $this->connection->readDataFromDB('numbers', [
                'cnt_id' => $countryId
            ]);
            $numberIds = array_map(function (array $row) {
                return $row['num_id'];
            }, $numbers);

        } else {
            $numberIds = null;
        }

        // Lets pretend we have some things inside: empty value checks, manipulation with DTOS etc
        $aggregatedLogs = $this->connection->readDataFromDB('send_log_aggregated', [
            'aggregation_date' => new \DB\RangeCriteria($from, $to),
            'num_id'           => $numberIds,
            'usr_id'           => $userId
        ]);

        $formattedLogs = $this->formatLogs($aggregatedLogs);

        return $formattedLogs;
    }

    /**
     * @param $aggregatedLogs
     * @return array
     */
    private function formatLogs($aggregatedLogs): array
    {
        $formattedLogs = [];
        foreach ($aggregatedLogs as $row) {
            $aggregationDate = $row['aggregation_date'];
            if (isset($formattedLogs[$aggregationDate])) {
                $formattedEntry            = $formattedLogs[$aggregationDate];
                $formattedEntry['success'] += $row['log_success_count'];
                $formattedEntry['total']   += $row['log_total_count'];
            } else {
                $formattedEntry = [
                    'success' => $row['log_success_count'],
                    'total'   => $row['log_total_count']
                ];
            }
            $formattedLogs[$aggregationDate] = $formattedEntry;
        }
        return $formattedLogs;
    }
}