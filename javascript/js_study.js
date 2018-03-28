/*var obj = {
    a: 1
};
(function (obj) {
    obj = {
        a: 2
    };

})();

console.log(obj.a);
*/

/*Logger = function (logFn) {

    _logFn = logFn;

    this.log = function (message) {
        _logFn(new Date() + ": " + message);
    }
}

var logger = new Logger(console.log);

logger.log("Hi!");
logger.log("Wazzup?");
*/

/*(function () {
    var a = b = 5;
})();
console.log(b);
*/
function test() {
    console.log(a);
    console.log(foo());

    var a = 1;
    function foo() {
        return 2;
    }
}

test();


/*var fullname = 'John Doe';
var obj = {
   fullname: 'Colin Ihrig',
   prop: {
      fullname: 'Aurelio De Rosa',
      getFullname: function() {
         return this.fullname;
      }
   }
};
  
console.log(obj.prop.getFullname());
  
var test = obj.prop.getFullname;
  
console.log(test());
*/

/*{	let a = 2, b = 3, c;
    // ..
    console.log(a, b, c);
}*/