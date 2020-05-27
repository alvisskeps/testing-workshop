<?php


use PF\BowlingGame;
use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{

    public function testGetScore_withAllZeros_returnsZeroScore()
    {
        // setup
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }

        // test
        $score = $game->getScore();

        // assertion
        self::assertEquals(0, $score);
    }

    public function testGetScore_withAllOnes_get20AsScore()
    {
        // setup
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assertion
        self::assertEquals(20, $score);
    }

    public function testGetScore_withASpare_getsSpareBonus()
    {
        // setup
        $game = new BowlingGame();
        $game->roll(8);
        $game->roll(2);
        $game->roll(5);

        // 8 + 2 + 5 + (bonus) + 17
        for ($i = 0; $i < 17; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assertion
        self::assertEquals(37, $score);
    }

    public function testGetScore_withAStrike_getsStrikeBonus()
    {
        // setup
        $game = new BowlingGame();

        $game->roll(10);

        $game->roll(3);
        $game->roll(5);

        // 10 + 3 (bonus) + 5 (bonus) + 3 + 5 + 16
        for ($i = 0; $i < 16; $i++) {
            $game->roll(1);
        }

        // test
        $score = $game->getScore();

        // assertion
        self::assertEquals(42, $score);
    }

    public function testGetScore_forAPerfectGame_shouldReturn300()
    {
        // setup
        $game = new BowlingGame();


        for ($i = 0; $i < 12; $i++) {
            $game->roll(10);
        }

        // test
        $score = $game->getScore();

        // assertion
        self::assertEquals(300, $score);
    }

    public function testRoll_withANegativeScore_shouldThrowException()
    {
        // setup
        $game = new BowlingGame();

        // Expect Exception
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Invalid roll score");
        $game->roll(-12);
    }

    public function testRoll_withTooHighScore_shouldThrowException()
    {
        // setup
        $game = new BowlingGame();

        // Expect Exception
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Invalid roll score");
        $game->roll(100);
    }

    public function testRoll_withInvalidScore_shouldThrowException()
    {
        // setup
        $game = new BowlingGame();

        // Expect Exception
        $this->expectException(TypeError::class);
        $game->roll(':what:');
    }

    public function testPlayGame_withMoreThanTwentyRolls_shouldThrowException()
    {
        // setup
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(2);
        }

        // Expect Exception
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Too many rolls");
        $game->roll(2);
    }
}