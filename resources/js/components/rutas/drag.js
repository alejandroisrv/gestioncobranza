import { ContainerMixin, ElementMixin } from 'vue-slicksort';

const SortableList = {
    mixins: [ContainerMixin],
    template: `
    <table class="col-md-12">
      <slot />
    </table>
  `
};



const SortableItem = {
    mixins: [ElementMixin],
    props: ['item'],
    methods: {
        deleteCliente() {
            console.log('aaa');
        }
    },
    template: `
      <tr class="list-item">
        <td collspan="2" > {{item.nombre}}  {{item.apellido}}</td>  
        <td> <small>{{  item.direccion}}</small> </td> 
        <td> <span @click="deleteCliente()" > &times; </span>  </td>
      </tr>
  `
};
export { SortableItem, SortableList }