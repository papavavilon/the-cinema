<?php

// Додаємо майбутні сеанси, пропускаючи вже наявні записи.
class ScheduleService
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    public function generate($days = 42)
    {
        $db = $this->db;
        $model = new ScheduleModel($db);
        $ids = $model->fetchMovie([])->fetchAll(PDO::FETCH_COLUMN);
        if (!$ids) {
            return;
        }
        $halls = $model->fetchCinemaHall([])->fetchAll(PDO::FETCH_COLUMN);
        foreach (range(0, $days - 1) as $day) {
            foreach ($halls as $hi => $hall) {
                foreach (["10:00:00", "14:30:00", "19:00:00"] as $slot => $time) {
                    $date = date("Y-m-d", strtotime("+" . $day . " days"));
                    if (strtotime($date . " " . $time) <= time()) {
                        continue;
                    }
                    $id = $ids[($day * 5 + $hi * 3 + $slot) % count($ids)];
                    if ($model->countScreening([$hall, $date, $time])->fetchColumn()) {
                        continue;
                    }
                    try {
                        $model->insertScreening([$date, $time, $hall, $id]);
                    } catch (PDOException $e) {
                        if ($e->getCode() !== "45000") {
                            throw $e;
                        }
                    }
                }
            }
        }
    }
}
