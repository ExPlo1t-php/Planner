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
/* ------------------------------------------------------------------------------ */
export function parseAndJoinPositions(positionsString){
    try {
        const namesArray = []
        const positionsArray = JSON.parse(positionsString);
        
        positionsArray.forEach(id => {
            if (id) {
                // console.log(id)
                const name = getNameById(this.positions, id);
                namesArray.push(name);
            }
        });
        return namesArray.join(', ');
    } catch (error) {
        console.error('Error parsing positions:', error);
    }
}
/* ------------------------------------------------------------------------------ */
