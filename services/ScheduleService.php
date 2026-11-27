<?php

// Додаємо кожному фільму щонайменше три майбутні сеанси без накладок у залах.
class ScheduleService
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function generate($days = 42)
    {
        $model = new ScheduleModel($this->db);
        $movies = $model->fetchMovie()->fetchAll(PDO::FETCH_ASSOC);
        $halls = $model->fetchCinemaHall()->fetchAll(PDO::FETCH_COLUMN);
        if (!$movies || !$halls) {
            return 0;
        }

        // Рахуємо наявні майбутні сеанси та зайнятий час кожного залу.
        $counts = array_fill_keys(array_column($movies, "Movie_ID"), 0);
        $occupied = [];
        foreach ($model->fetchFutureScreenings()->fetchAll(PDO::FETCH_ASSOC) as $screening) {
            $counts[$screening["Movie_ID"]] = ($counts[$screening["Movie_ID"]] ?? 0) + 1;
            $start = strtotime($screening["ShowDate"] . " " . $screening["ShowTime"]);
            $occupied[$screening["CinemaHall_ID"]][] = [
                $start,
                $start + $this->durationSeconds($screening["Duration"]) + 900
            ];
        }

        // Спершу заповнюємо фільми, яким бракує сеансів.
        $added = 0;
        $today = new DateTimeImmutable("today");
        for ($day = 0; $day < $days && min($counts) < 3; $day++) {
            $date = $today->modify("+{$day} days")->format("Y-m-d");
            foreach (["10:00:00", "14:30:00", "19:00:00"] as $time) {
                foreach ($halls as $hall) {
                    $start = strtotime($date . " " . $time);
                    if ($start <= time()) {
                        continue;
                    }

                    foreach ($movies as $movie) {
                        $id = $movie["Movie_ID"];
                        if ($counts[$id] >= 3) {
                            continue;
                        }
                        $end = $start + $this->durationSeconds($movie["Duration"]) + 900;
                        if ($this->overlaps($occupied[$hall] ?? [], $start, $end)) {
                            continue;
                        }

                        $model->insertScreening([$date, $time, $hall, $id]);
                        $occupied[$hall][] = [$start, $end];
                        $counts[$id]++;
                        $added++;
                        break;
                    }
                }
            }
        }

        return $added;
    }

    // Перетворюємо тривалість фільму на секунди.
    private function durationSeconds($duration)
    {
        $parts = array_map("intval", explode(":", $duration));
        return $parts[0] * 3600 + ($parts[1] ?? 0) * 60 + ($parts[2] ?? 0);
    }

    // Перевіряємо, чи вистачить часу в залі до або після іншого сеансу.
    private function overlaps(array $slots, $start, $end)
    {
        foreach ($slots as [$otherStart, $otherEnd]) {
            if ($start < $otherEnd && $end > $otherStart) {
                return true;
            }
        }
        return false;
    }
}
