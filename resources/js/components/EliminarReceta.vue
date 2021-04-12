<template>

 <input 
        type="submit" 
        class="btn btn-danger mr-1 d-block w-100 mb-2" 
        value="Eliminar x" 
        @click="eliminarReceta">

</template>

<script>
export default {
    
    props:['recetaId'],
    methods: {
        eliminarReceta(){

            this.$swal({
            title: '¿Deseas eliminar esta receta?',
            text: "Una vez eliminada, no se puede recuperar",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No'

            }).then((result) => {
            if (result.value) {

                const params = {

                    id: this.recetaId
                }

                //Enviar la peticion al servidor mediante axio
                axios.post(`/recetas/${this.recetaId}`, {params, _method: 'delete'})
                .then(respuesta => {

                    this.$swal({
                    title: 'Receta Eliminada',
                    text: 'Se elimino la receta',
                    icon: 'success'
                    });

                    //Eliminar receta del DOM
                    //para remover vamos al tbody que seria el papa del tr y edel td
                    //, luego removemos el td
                this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);
                })
                .catch(error => { 

                    console.log(error)
                })


            }
            })
        }
    }

}
</script>