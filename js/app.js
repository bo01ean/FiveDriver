/* Let's make each player unique */
function createUID(complexity){
    var space = "abcdef0123456789";
    var chars = space.split('');

    var tmp = [];
    var out = [];

    for(var j =0;j<complexity;j++)
    {
        for(var i = 0; i<= 4; i++)
        {
            tmp.push( chars[mt_rand(0,chars.length)] );
        }
        out.push(tmp.join(''));
        tmp = [];
    }
    return out.join('-');
}
//http://phpjs.org/functions/mt_rand/
function mt_rand (min, max) {
    // http://kevin.vanzonneveld.net
    // +   original by: Onno Marsman
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   input by: Kongo
    // *     example 1: mt_rand(1, 1);
    // *     returns 1: 1
    var argc = arguments.length;
    if (argc === 0) {
        min = 0;
        max = 2147483647;
    }
    else if (argc === 1) {
        throw new Error('Warning: mt_rand() expects exactly 2 parameters, 1 given');
    }
    else {
        min = parseInt(min, 10);
        max = parseInt(max, 10);
    }
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
// Reused code - copyright Moveable Type Scripts - retrieved May 4, 2010.
// http://www.movable-type.co.uk/scripts/latlong.html
// Under Creative Commons License http://creativecommons.org/licenses/by/3.0/
function calculateDistance(lat1, lon1, lat2, lon2) {
    var R = 6371; // km
    var dLat = (lat2-lat1).toRad();
    var dLon = (lon2-lon1).toRad();
    var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c;
    return d;
}
Number.prototype.toRad = function() {
    return this * Math.PI / 180;
}