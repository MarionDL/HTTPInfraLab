var Chance = require('chance');
var chance = new Chance();

var express = require('express');
var app = express();

app.get('/', function(req, res) {
    res.send(generateSentence());
});

app.listen(3000, function() {
    console.log('Accepting HTTP requests on port 3000.');
});

function generateSentence() {
    var sentences = [];
    for (var i = 0; i < 3; ++i) {
        var newSentence = "Hello there! " + chance.animal({type: 'zoo'});
        sentences.push(newSentence);
    }
    console.log(sentences);
    return sentences;
}