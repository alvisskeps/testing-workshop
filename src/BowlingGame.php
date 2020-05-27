<?php


namespace PF;


use Exception;

class BowlingGame
{

    private array $rolls = [];

    /**
     * @param int $points
     *
     * @throws Exception
     */
    public function roll(int $points): void
    {
        if ($points < 0 || $points > 10) {
            throw new Exception('Invalid roll score');
        }

        $this->rolls[] = $points;

        if (count($this->rolls) > 20) {
            throw new Exception('Too many rolls');
        }
    }

    public function getScore(): int
    {
        $score = 0;
        $roll = 0;

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->isStrike($roll)) {
                $score += $this->getStrikePoints($roll);
                ++$roll;
                continue;
            }

            if ($this->isSpare($roll)) {
                $score += $this->getSpareBonus($roll);
            }
            $score += $this->getNormalScore($roll);
            $roll += 2;
        }

        return $score;
    }

    /**
     * @param int $roll
     * @return int
     */
    public function getNormalScore(int $roll): int
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    /**
     * @param int $roll
     * @return bool
     */
    public function isSpare(int $roll): bool
    {
        return $this->getNormalScore($roll) === 10;
    }

    /**
     * @param int $roll
     * @return int
     */
    public function getSpareBonus(int $roll): int
    {
        return $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     *
     * @return bool
     */
    public function isStrike(int $roll): bool
    {
        return $this->rolls[$roll] === 10;
    }

    /**
     * @param int $roll
     *
     * @return int
     */
    public function getStrikePoints(int $roll): int
    {
        return 10 + $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }
}