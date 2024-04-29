//Disclaimer: er is natuurlijk hier en daar gebruik gemaakt van CHATGPT en andere middelen.
// Maar ik neem aan dat ik op de opdracht moet afgaan hoe ik normaal zou coderen. :)

// Establish card types and levels
const TYPES = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
const LEVELS = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Q', 'K'];

// Function to create and shuffle a deck of cards
function createDeck() {
    const deck = [];

    // make sure the cards come with unique types and levels
    for (const type of TYPES) {
        for (const level of LEVELS) {
            deck.push({ type, level });
        }
    }
    return shuffle(deck);
}

// Function to shuffle an array
function shuffle(array) {
    for (let i = array.length - 1; i > 0; i--) {

        //Generate a random number between 0 and i
        const j = Math.floor(Math.random() * (i + 1));

        // Swap the values (cardswap)
        [array[i], array[j]] = [array[j], array[i]];
    }
    return array;
}

// Function to deal cards to players
function dealCards(deck, numPlayers, numCardsPerPlayer) {
    const players = [];

    // set up a loop to deal cards to each player
    for (let i = 0; i < numPlayers; i++) {
        const hand = [];

        // ---
        for (let j = 0; j < numCardsPerPlayer; j++) {
            hand.push(deck.pop());
        }
        players.push(hand);
    }
    return players;

}

// Function to play the card game
function playGame() {
    // Create and shuffle the deck
    let deck = createDeck(48);

    // Deal cards to players
    const numPlayers = 4;
    const numCardsPerPlayer = 7;
    const players = dealCards(deck.slice(), numPlayers, numCardsPerPlayer);

    //cards left become the cardPile
    let cardPile = deck.slice(numPlayers * numCardsPerPlayer);

    // Discard pile setup
    const discardPile = [deck.pop()];

    // Output initial game state
    console.log('Game starts!');
    console.log('Shuffeling cards...');
    console.log('Moving top card of the deck to the discard pile: ', discardPile[0]);
    console.log('Players and their hands:');

    // For loop displaying players and their hands
    for (let i = 0; i < numPlayers; i++) {
        console.log(`Player ${i + 1}:`, players[i]);
    }

    // Simulate turns until a player wins
    let currentPlayerIndex = 0;
    while (true) {
        const currentPlayer = players[currentPlayerIndex];
        console.log(`\nPlayer ${currentPlayerIndex + 1}'s turn:`);
        console.log(`Current card on discard pile: ${discardPile[discardPile.length - 1].level} of ${discardPile[discardPile.length - 1].type}`);

        /* check if pile empty
        if (cardPile.length === 0 && !drawCard) {
            console.log('Empty card pile... Skipping player/s turn.');

            // Skip the players turn
            currentPlayerIndex = (currentPlayerIndex + 1) % numPlayers;
            continue;
        } */

        // Check if the player has a playable card (Was stuck on this one so GPT helped me out)
        const validCards = currentPlayer.filter(card => card.type === discardPile[discardPile.length - 1].type || card.level === discardPile[discardPile.length - 1].level);
        if (validCards.length > 0) {

            //Player has a playable card, autoplay
            const cardToPlay = validCards[0];
            console.log(`Player ${currentPlayerIndex + 1} plays: ${cardToPlay.level} of ${cardToPlay.type}`);

            // remove card from hand and add it to the pile
            const cardIndex = currentPlayer.indexOf(cardToPlay);
            currentPlayer.splice(cardIndex, 1);
            discardPile.push(cardToPlay);
        } else {

            //player can't play and has to draw a card
            if (cardPile.length > 0) {
                const drawnCard = cardPile.pop();
                console.log(`Player ${currentPlayerIndex + 1} draws: ${drawnCard.level} of ${drawnCard.type}, Skipping their turn!`);
                currentPlayer.push(drawnCard);
            } else {
                console.log(`card pile is empty. Player ${currentPlayerIndex + 1} cannot draw a card`)
            }
        }

        // After every turn check if a player has 0 cards left to play and deem them the winner
        const winner = players.find(player => player.length === 0);
        if (winner) {
            console.log(`\nPlayer ${players.indexOf(winner) + 1} Has no cards left... Player ${players.indexOf(winner) + 1} wins!`);
            break;
        }

        // Just a simple next turn skipper
        currentPlayerIndex = (currentPlayerIndex + 1) % numPlayers;
    }
}

playGame();