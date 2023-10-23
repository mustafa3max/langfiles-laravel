const strings = @json(LF::ready());
const elStr = document.querySelectorAll("[lf]");
var index = 0;
elStr.forEach(element => {
    element.innerText = strings[element.getAttribute('lf')];
    index++;
});
