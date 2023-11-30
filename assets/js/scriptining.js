var map = document.querySelector('#map')
    
var paths = map.querySelectorAll('.map__image a')

// Polyfill foreach
    if (NodeList.prototype.forEach === undefined) {
        NodeList.prototype.forEach = function (callback) {
        [].forEach.call(this, callback)
    }
}

var activeArea= function (id)  {
    map.querySelectorAll('.is-active').forEach(function (item) {
        item.classList.remove('is-active')
})
    if (id !== undefined) {
        document.querySelector('#region-' + id).classList.add('is-active')
    }
}

paths.forEach(function (path) {
    path.addEventListener('mouseenter', function () {
        var id = this.id.replace('region-','')
        activeArea(id)
    })
})

map.addEventListener('mouseleave', function () {
    activeArea()
})