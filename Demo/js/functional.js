// Car Makes
const fordList = document.getElementsByClassName("ford");
const toyotaList = document.getElementsByClassName("toyota");
const seatList = document.getElementsByClassName("seat");

const addModel = document.getElementById('model');
// Functions
function showCarModel(carList){
    for(let i = 0; i < carList.length; i++) {
        carList[i].classList.remove("hide");
    }
}
function hideCarModel(carList){
    for(let i = 0; i < carList.length; i++) {
        carList[i].classList.add("hide");
    }
}

function resetCarModelOptions(){
    hideCarModel(fordList);
    hideCarModel(toyotaList);
    hideCarModel(seatList);

    resetSelectElement(addModel);
}


function resetSelectElement(selectElement) {
    var options = selectElement.options;

    // Look for a default selected option
    for (var i=0, iLen=options.length; i<iLen; i++) {

        if (options[i].defaultSelected) {
            selectElement.selectedIndex = i;
            return;
        }
    }
    // If no option is the default, select first or none as appropriate
    selectElement.selectedIndex = -1; // or -1 for no option selected
}