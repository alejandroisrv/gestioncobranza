
const user = JSON.parse(localStorage.getItem('auth'));
export default {
    methods: {
        $isAdmin () {
            if(user && user.role == 1){
                return true;
            }
            return false;
        },
        $isAdminBodega () {
            if(user && (user.role == 2 || user.role == 1)){
                return true;
            }
            return false;
        },
        $isCobrador () {
            if(user && (user.role == 3 || user.role == 1)){
                return true;
            }
            return false;
        },
        $isVendedor () {
            if(user && (user.role == 4 || user.role == 1)){
                return true;
            }
            return false;
        },
      }
  }
