<?php

enum Shape: int {
    public const X = self::ROCK;
    public const Y = self::PAPER;
    public const Z = self::SCISSORS;
    public const A = self::ROCK;
    public const B = self::PAPER;
    public const C = self::SCISSORS;

    case ROCK = 1;
    case PAPER = 2;
    case SCISSORS = 3;

    public function beats(self $opponent): ?bool
    {
        return match ($opponent) {
            self::ROCK => $this === self::PAPER ? true : ($this === self::SCISSORS ? false : null),
            self::PAPER => $this === self::SCISSORS ? true : ($this === self::ROCK ? false : null),
            self::SCISSORS => $this === self::ROCK ? true : ($this === self::PAPER ? false : null),
        };
    }

    public static function convert(string $letter): Shape
    {
        return constant('Shape::'.$letter);
    }
}

$games = fopen('input.txt', 'r');
$score = 0;

while (!feof($games)) {
    $line = trim(fgets($games));
    if (empty($line)) {
        continue;
    }
    [$opponent, $player] = array_map('strtoupper',explode(' ', $line));

    $opponent = Shape::convert($opponent);
    $player = Shape::convert($player);
    $points = match ($player->beats($opponent)) {
        true => 6,
        false => 0,
        default => 3
    };

    echo implode(' ', [
        'This round played',
        implode(' ', [
            'Opponent:',
            $opponent->name,
            'Player:',
            $player->name
        ]),
        $player->value,
        '+',
            (string)$points
    ]).PHP_EOL;

    $score += $points + $player->value;
    // Part 1
    echo "Total Score: $score". PHP_EOL;
}
