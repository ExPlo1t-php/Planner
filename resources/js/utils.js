/* A bunch of reusable function that's used throughout the application,
 my apologies since many things are uncommented, I ve tried to rush the development process
 if you have any questions regarding something, please DM me in discord:         "explo1t."
*/ 
import moment from 'moment';
import {ref} from 'vue'

export function getNameById(object, id) {
// Retrieves the name or first name from an object based on the provided ID.
    if(id!== null){
        const foundObject = object.find(obj => obj.id == id);
        if(foundObject){
            if (foundObject.name){
                return foundObject ? foundObject.name : null;
            }else{
                return foundObject ? foundObject.first_name : null;
            }
        } 
    }
}
export function getIdByName(object, name) {
// Retrieves the id or first based on the provided name.
    if(name!== null){
        const foundObjectName = object.find(obj => obj.name == name);
        const foundObjectFirstName = object.find(obj => obj.first_name == name);
        if (foundObjectName.name){
            return foundObjectName ? foundObjectName.name : null;
        }else{
            return foundObjectFirstName ? foundObjectFirstName.first_name : null;
        }
    }
}

export function objectFinder(object, id){
    // searches for an object inside another object and return it
    const foundObject = object.find(obj => obj.id == id);
    return foundObject;
}

//  dates=====================================
export function checkDateValidity(date){
    const currentDate = new Date();
    const enteredDate = new Date(date);
    // setting time to 0 to validate only date
    currentDate.setHours(0, 0, 0, 0);
    enteredDate.setHours(0, 0, 0, 0);

    if (enteredDate < currentDate) {
        return false;
    } else if (enteredDate > currentDate) {
        return true;
    } else {
        return true;
    }
}

export function getWeekNumber(){
    const date = new Date();
    const startDate = new Date(date.getFullYear(), 0, 1);
    const days = Math.floor((date - startDate) / (24 * 60 * 60 * 1000));
    const weekNumber = Math.ceil((days + 1 + startDate.getDay()) / 7);
    return weekNumber;
}

export function getCurrentYear() {
  const currentDate = new Date();
  const currentYear = currentDate.getFullYear();
  return currentYear;
}

export function format (value) {
    return moment(value).format('DD-MM-YYYY');
}

export function timeDiff(startDate, endDate){
    const diff = moment(endDate).diff(moment(startDate))
    const duration = moment.duration(diff)
    return duration.days()
}

export function getValiditySvg(bool){
    if(bool){
        return ` <title>valid</title><svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="#23DC3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>`
    }else{
        return `<svg width="30px" height="30px" viewBox="0 0 512 512" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <title>invalid</title>
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="work-case" fill="#FF9494" transform="translate(91.520000, 91.520000)">
                <polygon id="Close" points="328.96 30.2933333 298.666667 1.42108547e-14 164.48 134.4 30.2933333 1.42108547e-14 1.42108547e-14 30.2933333 134.4 164.48 1.42108547e-14 298.666667 30.2933333 328.96 164.48 194.56 298.666667 328.96 328.96 298.666667 194.56 164.48">
                </polygon>
                        </g>
                    </g>
                </svg>`
    }
}
/* ========================================================================== */
export function parseAndJoinPositions(positionsString, positions){
    try {
        const namesArray = []
        const positionsArray = JSON.parse(positionsString);
        
        positionsArray.forEach(function (id) {
            if (id) {
                // console.log(id)
                const name = getNameById(positions, id);
                namesArray.push(name);
            }
        });
        return namesArray.join(', ');
    } catch (error) {
        console.error('Error parsing positions:', error);
    }
}

export function  addObjectToArray(message, object) {
// adds a null value object to an array of objects
    const newObject = {
        id: '',
        name: message,
        positions: [],
    };
    object.unshift(newObject)
}

export function getDepartmentPositions(departments, id){
    // this  method fetches the  positions  available   in  the selected department
    if(id!=null && departments){
        const department = departments.find(department => department.id == id);
        // console.log(department)
        if (department) {
            return JSON.parse(department.positions)
        } else {
            return null
        }
    }
} 
    
export function getPositions(positions, departmentPos){
    // this  method takes an array of department positions from "getDepartmentPositions"
    // then it fetches the positions based on the name key provided  in the getDepartmentPositions array
    if (departmentPos) {
        const filteredData = positions.filter(object =>
        departmentPos.includes(object.id)
        );
        return filteredData
    } else {
        return null
    }
}
/* ========================================================================== */


/* ========================================================================== */
    // accordion related functions
// unused code (for now)
export function toggleItem(itemId) {
    const accordionState = JSON.parse(localStorage.getItem('accordionState')) || {};
    accordionState[itemId] = accordionState[itemId] === 'open' ? 'closed' : 'open';
    localStorage.setItem('accordionState', JSON.stringify(accordionState));
}

export function isAccordionOpen(itemId) {
    const accordionState = JSON.parse(localStorage.getItem('accordionState'));
    return accordionState && accordionState[itemId] === 'open';
}

export function loadAccordionState() {
    const accordionState = JSON.parse(localStorage.getItem('accordionState'));
    if (accordionState) {
      Object.keys(accordionState).forEach((itemId) => {
        const isOpen = accordionState[itemId] === 'open';
        // Emit toggle event to update the state of each accordion item
        this.$emit('toggle', { itemId, isOpen });
      });
    }
}
/* ========================================================================== */

/* ==================================Planning========================= */
export function startPlanning(){

}

export function addDepartment(weekDetails, departmentId){
    const days = ['MON','TUE','WED','THU','FRI'];
    const departmentExists = weekDetails.some(obj => obj.department == departmentId)
    if (departmentId && !departmentExists) {
        const newDepartment = {department: departmentId, days:[]};
        days.forEach(day => {
            newDepartment.days.push({
                day: day,
                employees: []
            });
        });
        weekDetails.push(newDepartment);
        return true
    }else{
        alert('L\'article existe déjà')
    }
};



/* ========================================================================== */