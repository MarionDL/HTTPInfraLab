var Chance = require('chance');
var chance = new Chance();

var express = require('express');
var app = express();

app.get('/', function(req, res) {
    res.send(generateStudents());
});

app.listen(3000, function() {
    console.log('Accepting HTTP requests on port 3000.');
});

// Generation d'etudiants aleatoires
function generateStudents() {
    // On peut aller de 0 à 10 etudiants
    var nbOfStudents = chance.integer({
        // Set des bornes
        min: 0,
        max: 10
    });
    // Affichage du nombre d'etudiants
    console.log(nbOfStudents);
    // Tableau de resultats
    var students = [];
    // Generation de donnees aleatoires
    for (var i = 0; i < nbOfStudents; ++i) {
        var gender = chance.gender();
        var birthYear = chance.year({
            min: 1985,
            max: 2000
        });
        // Insertion des donnees
        students.push({
            firstName: chance.first({
                // Prenom specifique au genre
                gender: gender
            }),
            lastName: chance.last(),
            gender: gender,
            birthday: chance.birthday({
                year: birthYear
            })
        });
    };
    console.log(students);
    return students;
}