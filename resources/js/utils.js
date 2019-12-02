export default {
    converParamters (object) {
        var query = ''

        if (object === null)
            return query;
        let arr = Object.entries(object)

        if (arr.length > 0) {
            for (let i = 0; i < arr.length; i++) {
                if (arr[i][1] !== '' && arr[i][1] !== null && arr[i][1] !== 'all' && arr[i][1] !== 'otros' && arr[i][1] !== undefined) {
                    if (query == '') {
                        query += `?${arr[i][0]}=${arr[i][1]}`
                    } else {
                        query += `&${arr[i][0]}=${arr[i][1]}`
                    }

                }
            }
        }
        console.log(query);
        return query;
    },
    select2Fortmat(datos){
      if(datos && datos==undefined && datos.length==0) return []
      try {
        let format=[];
        for(let i=0;i < datos.length; i++){
            format.push({id:datos[i].id,label:datos[i].nombre || datos[i].name || datos[i].direccion })
        }
        return format;
      } catch (e) {
         console.log(e);
      }
    }
}
