<?php

namespace spec\Halloween\TrickOrTreat\Domain\Game;

use Halloween\TrickOrTreat\Domain\Game\Event\CurrentRoundHasBeenFinished;
use Halloween\TrickOrTreat\Domain\Game\Event\GameHasFinished;
use Halloween\TrickOrTreat\Domain\Game\Event\GameWasInitialised;
use Halloween\TrickOrTreat\Domain\Game\Event\GameWasStarted;
use Halloween\TrickOrTreat\Domain\Game\Event\PlayerOneHasEatenHisMeal;
use Halloween\TrickOrTreat\Domain\Game\Event\PlayerTwoHasEatenHisMeal;
use Halloween\TrickOrTreat\Domain\Game\GameId;
use Halloween\TrickOrTreat\Domain\Game\Player;
use PhpSpec\ObjectBehavior;

/**
 * @mixin \Halloween\TrickOrTreat\Domain\Game\Game
 */
class GameSpec extends ObjectBehavior
{
    private $gameId;

    function let()
    {
        $this->gameId = GameId::generate();
        $this->beConstructedThrough('initializeWithPlayerNames', [$this->gameId, 'Mitchel', 'Petar']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveRecorded(GameWasInitialised::class);
    }

    function it_should_be_startable()
    {
        $this->start();

        $this->shouldHaveRecorded(GameWasStarted::class);

    }

    function it_should_confirm_the_player_one_ate_the_mail()
    {
        $this->playerOneAteMeal();

        $this->shouldHaveRecorded(PlayerOneHasEatenHisMeal::class);
    }

    function it_should_confirm_the_player_two_ate_the_mail()
    {
        $this->playerTwoAteMeal();

        $this->shouldHaveRecorded(PlayerTwoHasEatenHisMeal::class);
    }

    function it_should_finish_the_round()
    {
        $this->playerOneAteMeal();

        $this->playerTwoAteMeal();

        $this->finishRound();

        $this->shouldHaveRecorded(CurrentRoundHasBeenFinished::class);
    }

    function it_should_not_finish_a_round_when_not_both_players_have_eaten(){
        $this->shouldThrow(\LogicException::class)->duringFinishRound();
        $this->playerOneAteMeal();
        $this->shouldThrow(\LogicException::class)->duringFinishRound();
        $this->playerTwoAteMeal();
        $this->shouldNotThrow(\LogicException::class)->duringFinishRound();
    }

    function it_should_end_a_game_when_player_one_quits() {
        $this->start();
        $this->playerOneQuits();

        $this->shouldHaveRecorded(GameHasFinished::withWinnerInRound($this->gameId, new Player('Petar'), 1));
    }


    function it_should_end_a_game_when_player_two_quits() {
        $this->start();
        $this->playerTwoQuits();

        $this->shouldHaveRecorded(GameHasFinished::withWinnerInRound($this->gameId, new Player('Mitchel'), 1));
    }
}