function submitVote(element) {
    const characterId = element.getAttribute('data-character-id');
    const charactername = element.getAttribute('data-character-name');
    const characterfname = element.getAttribute('data-character-fname');
    const characterseries = element.getAttribute('data-character-series');
    const charactergender = element.getAttribute('data-character-gender');
    // Optionally, you can add a hidden input to carry the character ID if it's not already part of the form
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'winnerid';
    input.value = characterId;
    const input2 = document.createElement('input');
    input2.type = 'hidden';
    input2.name = 'winnername';
    input2.value = charactername;
    const input3 = document.createElement('input');
    input3.type = 'hidden';
    input3.name = 'winnerfname';
    input3.value = characterfname;
    const input4 = document.createElement('input');
    input4.type = 'hidden';
    input4.name = 'winnerseries';
    input4.value = characterseries;
    const input5 = document.createElement('input');
    input5.type = 'hidden';
    input5.name = 'winnergender';
    input5.value = charactergender;
    document.getElementById('voteForm').appendChild(input);
    document.getElementById('voteForm').appendChild(input2);
    document.getElementById('voteForm').appendChild(input3);
    document.getElementById('voteForm').appendChild(input4);
    document.getElementById('voteForm').appendChild(input5);

    // Submit the form
    document.getElementById('voteForm').submit();
}