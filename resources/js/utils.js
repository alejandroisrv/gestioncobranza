
export default {
    converParamters (object) {

        let query = ''
        if(object===undefined || object===null) return query;
        let arr = Object.entries(object)
        if(arr.length > 0) {

            if(arr[0][1] !== '' && arr[0][1] !== null && arr[0][1]!==undefined ){
                query += `?${arr[0][0]}=${arr[0][1]}`
            }

            if(arr.length >= 1) {

                for(let i = 1; i < arr.length; i++) {
                    if(arr[i][1] !== '' && arr[i][1] !== null && arr[0][1]!==undefined) {
                        if(query === '') {
                            query += `?${arr[i][0]}=${arr[i][1]}`
                        }else{
                            query += `&${arr[i][0]}=${arr[i][1]}`
                        }

                    }
                }
            }

        }

        return query;
    },
    select2Fortmat(datos){
      if(datos==undefined && datos.length==0) return []
      try {
        let format=[];
        for(let i=0;i < datos.length; i++){
            format.push({id:datos[i].id,label:datos[i].nombre || datos[i].direccion || datos[i].name })
        }
        return format;
      } catch (e) {
         console.log(e);
      }
    }
}
