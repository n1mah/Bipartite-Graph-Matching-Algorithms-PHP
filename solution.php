<?php

function RoundTable(int $n, int $m, array $connections): string {
    $table_1 = [];
    $table_2 = [];

    for ($i = 1; $i <= $n; $i++) {
        $graph[$i]=[];
        $color[$i]=-1;
    }
    foreach ($connections as [$a, $b]) {
        $graph[$a][] = $b;
        $graph[$b][] = $a;
    }

    for ($i = 1; $i <= $n; $i++) {
        if ($color[$i] === -1) {
            if (empty($graph[$i])) {
                if (count($table_1) <= count($table_2)) {
                    $table_1[] = $i;
                } else {
                    $table_2[] = $i;
                }
                $color[$i] = 0;
                continue;
            }

            $queue = [$i];
            $color[$i] = 0;

            $temp0 = [$i];
            $temp1 = [];

            while (!empty($queue)) {
                $current = array_shift($queue);

                foreach ($graph[$current] as $neighbor) {
                    if ($color[$neighbor] === -1) {
                        $color[$neighbor] = 1 - $color[$current];
                        $queue[] = $neighbor;

                        if ($color[$neighbor] === 0) {
                            $temp0[] = $neighbor;
                        } else {
                            $temp1[] = $neighbor;
                        }

                    } elseif ($color[$neighbor] === $color[$current]) {
                        return json_encode(["possible" => "NO"]);
                    }
                }
            }

            $table_1 = array_merge($table_1, $temp0);
            $table_2 = array_merge($table_2, $temp1);
        }
    }

    return json_encode([
        "possible" => "YES",
        "table_1" => $table_1,
        "table_2" => $table_2,
    ]);
}
