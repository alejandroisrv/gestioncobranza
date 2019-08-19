
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
  template: `
      <tr class="list-item">
        <td collspan="2"> {{item.nombre}}  {{item.apellido}}</td>  <td> <small>{{  item.direccion}}</small>  </td> 
      </tr>
  `
};
export { SortableItem,SortableList }