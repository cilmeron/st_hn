function submitVote(element) {
    const characterId = element.getAttribute('data-character-id');
    // Optionally, you can add a hidden input to carry the character ID if it's not already part of the form
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'winnerid';
    input.value = characterId;
    document.getElementById('voteForm').appendChild(input);
    
    // Submit the form
    document.getElementById('voteForm').submit();
}