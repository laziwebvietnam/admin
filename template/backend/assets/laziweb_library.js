Array.prototype.remove = function(el) {
    return this.splice(this.indexOf(el), 1);
}