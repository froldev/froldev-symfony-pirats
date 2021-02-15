function onClickMoveBoat(event) {
    event.preventDefault();
    const url = this.href;
    moveBoat('url-ok', url);
}

// function move boat
function moveBoat(action = null, url = null) {
    const boat = document.getElementById('boat');
    const situation = document.getElementById('situation');
    const longitude = document.getElementById('longitude');
    const latitude = document.getElementById('latitude');

    if (action == "url-no") {
        let str = window.location.href
        let newUrl = str.replace('/map', '/boat/direction/'+url);
        url = newUrl;
    };

    axios.post(url)
    .then(function (response) {
        if (response.data.message == 'success') {
            window.location.href = str.replace('/map', '/victory');
        } else {
            const coordBoat = response.data.x + ',' + response.data.y;
            const coords = document.getElementsByClassName('coords');
            const tile = Array.prototype.filter.call(coords, function (tileName) {
                if (tileName.textContent == coordBoat) {
                    const parent = tileName.parentElement;
                    parent.appendChild(boat);
                    if (parent.classList.contains('port')) {
                        situation.textContent = 'Port';
                    } else if (parent.classList.contains('island')) {
                        situation.textContent = 'Ile';
                    } else {
                        situation.textContent = 'Mer';
                    };
                    longitude.textContent = response.data.x;
                    latitude.textContent = response.data.y;
                    return false;
                };
        
            });
        }
    }).
    catch(function (error) {
        window.alert("Il y a de la tempête et le bateau ne peut plus bouger !!!!");
    });
}

// move with compass
document.querySelectorAll('a.js-move').forEach(function (move) {
move.addEventListener('click', onClickMoveBoat);
});

// move with keys of keyboard
document.addEventListener('keydown', function (event) {
    let direction = '';
    if (event.code === "ArrowUp") {
    direction = "N";
    } else if (event.code === "ArrowDown") {
    direction = "S";
    } else if (event.code === "ArrowLeft") {
    direction = "W";
    } else if (event.code === "ArrowRight") {
    direction = "E";
    }
    moveBoat('url-no', direction);
});