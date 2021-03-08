<template>
    <main class="main">     
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Inscripcion de Aumnos                    
                </div>

                <div class="card-body">
                    <div class="form-row form-group">
                        <label>Seleccione un Alumno: </label>
                    </div>                                           
                    
                    <div class="form-row form-group border">                                                        
                        <div class="form-group col-md-3">                                        
                            <label>Nombre</label>                                                                                  
                            <input type="text" readonly class="form-control" v-model="nombreAlumno">                                                                                                                                                                                                                                              
                        </div> 
                        <div class="form-group col-md-3">                                    
                            <label>CI</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="ciAlumno">                                                                                                                                                                                                                         
                        </div>
                        <div class="form-group col-md-3">                                                                       
                            <label>Sexo</label>                                           
                            <input type="text" readonly value="0" class="form-control" v-model="sexoAlumno">                                                                                                                                                             
                        </div>
                        <div class="form-group col-md-2">                                
                            <div class="form-inline">                                                                               
                                <button @click="abrirModal('alumnos')" class="btn btn-primary form control btnbuscar">Seleccionar Alumno</button>                                        
                            </div>                                
                        </div>                                                                                                                                                                                                                                                                                                              
                    </div>


                    <div class="form-row form-group border">
                        <div class="form-group col-md-3" v-show="swModalCursoParalelo == 1">
                            <div class="form-inline">
                                <button type="button" @click="abrirModal('agregarInscripcion')" class="btn btn-secondary form control btnAgregarOferta">
                                    <i class="fa fa-plus"></i>&nbsp;Añadir Inscripcion
                                </button>
                            </div>
                        </div>

                        <div class="form-group table-responsive col-md-12">                    
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>                                        
                                        <th>Nivel</th>                                        
                                        <th>Curso</th>
                                        <th>Paralelo</th>                                                                                                                                                                                                                      
                                        <th>Gestion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-show="swMostrarInscripcion == 1" v-for="inscripcion in arrayInscripcion" :key="inscripcion.id">                                        
                                        <td v-text="inscripcion.Nivel"></td>
                                        <td v-text="inscripcion.Curso"></td>
                                        <td v-text="inscripcion.Paralelo"></td>
                                        <td v-text="inscripcion.Gestion"></td>                                                                                                                                                                                                                                                                                                                     
                                    </tr>

                                    <tr v-show="swMostrarInscripcion == 0">                                        
                                        <td colspan="4" v-text="mensajeNoTieneInscripcion"></td>                                                                                                                                                                                                                                                                                                                                                            
                                    </tr>                                                               
                                </tbody>
                            </table>
                        </div>                        
                    </div>                                       
                </div>

            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>

        <!--Modal para Alumnos-->
        <div class="modal" tabindex="-1" :class="{'mostrar' : modalAlumno}" role="dialog" aria-labelledby="myModalLabel" style="display: none; overflow-y: scroll;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioAlumno">                                        
                                        <option value="Nombre">Nombre</option>
                                        <option value="CI">CI</option>                                                                                
                                    </select>
                                    <input type="text" v-model="buscarAlumno" @keyup.enter="listarAlumnos(1, buscarAlumno, criterioAlumno)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarAlumnos(1, buscarAlumno, criterioAlumno)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar</button>
                                </div>
                                <span>(*)Para visualizar todos los Alumnos haga una busqueda en blanco</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nombre</th>
                                        <th>CI</th>                                        
                                        <th>Fecha Nacimiento</th>                               
                                        <th>Sexo</th>
                                        <th>Direccion</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(alumno, index) in arrayAlumnos" :key="index">
                                        <td>
                                            <button type="button" @click="seleccionarAlumno(alumno)" class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i>
                                            </button> 
                                        </td>
                                        <td v-text="alumno.Nombre"></td>
                                        <td v-text="alumno.CI"></td>                                        
                                        <td v-text="alumno.FechaNac"></td>
                                        <td v-text="alumno.Sexo"></td>
                                        <td v-text="alumno.Direccion"></td>                                                                    
                                        <td v-text="alumno.Telefono"></td>
                                        <td v-text="alumno.Email"></td>                                    
                                    </tr>                                
                                </tbody>
                            </table>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscarAlumno, criterioAlumno)">Ant</a>
                                    </li>

                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscarAlumno, criterioAlumno)" v-text="page"></a>
                                    </li>       

                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscarAlumno, criterioAlumno)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>                        
                    </div>                             

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->

        <!--Modal para Curso Paralelo-->
        <div class="modal" tabindex="-1" :class="{'mostrar' : modalCursoParalelo}" role="dialog" aria-labelledby="myModalLabel" style="display: none; overflow-y: scroll;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioCursoParalelo">                                        
                                        <option value="Nivel.Nombre">Nivel</option>
                                        <option value="Curso.Nombre">Curso</option>
                                        <option value="Paralelo.Nombre">Paralelo</option>                                                                               
                                    </select>
                                    <input type="text" v-model="buscarCursoParalelo" @keyup.enter="listarCursosParalelos(1, buscarCursoParalelo, criterioCursoParalelo)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarCursoParalelos(1, buscarCursoParalelo, criterioCursoParalelo)" class="btn btn-primary"><i class="fa fa-search"></i>Buscar</button>
                                </div>
                                <span>(*)Para visualizar todos los Cursos Paralelos haga una busqueda en blanco</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Nivel</th>
                                        <th>Curso</th>                                        
                                        <th>Paralelo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(cursoParalelo, index) in arrayCursoParalelo" :key="index">
                                        <td>
                                            <button type="button" @click="seleccionarCursoParalelo(cursoParalelo)" class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i>
                                            </button> 
                                        </td>
                                        <td v-text="cursoParalelo.Nivel"></td>
                                        <td v-text="cursoParalelo.Curso"></td>                                        
                                        <td v-text="cursoParalelo.Paralelo"></td>                                        
                                    </tr>                                
                                </tbody>
                            </table>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscarCursoParalelo, criterioCursoParalelo)">Ant</a>
                                    </li>

                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscarCursoParalelo, criterioCursoParalelo)" v-text="page"></a>
                                    </li>       

                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscarCursoParalelo, criterioCursoParalelo)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>                        
                    </div>                             

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->

    </main>
</template>

<script>

    import Vue from 'vue';
    // Import component
    import Loading from 'vue-loading-overlay';
    // Import stylesheet
    import 'vue-loading-overlay/dist/vue-loading.css';
    // Init plugin
    Vue.use(Loading);


    export default {                  
        data() {
            return {               
                idInscripcion: 0,
                
                idAlumno: 0,
                nombreAlumno: '',                
                ciAlumno: 0,
                sexoAlumno: '',                
                
                arrayInscripcion: [],               
                arrayAlumnos: [],
                arrayCursoParalelo: [],                                            

                //Id CursoParalelo
                idCursoParalelo: 0,         
                
                //Para la busqueda en el modal Profesor
                criterioAlumno: 'Nombre',
                buscarAlumno: '',

                //Para la busqueda en el modal Curso Paralelo
                criterioCursoParalelo: 'Nivel.Nombre',
                buscarCursoParalelo: '',
        
                modalAlumno: 0,
                modalCursoParalelo: 0,
                tituloModal: '',

                //switches
                swModalCursoParalelo: 0,
                swMostrarInscripcion: 0, 

                //variable para controlar que se agregue almenos una oferta


                mensajeNoTieneInscripcion: "El estudiante no tiene inscripcion para esta gestion",
                

                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                },
                offset: 3,            
                //opciones para Vue loading overlay        
                optionsLoadingOverlay : {                        
                    canCancel: false,
                    color: '#007BFF',
                    height:	128,
                    width: 128
                },
                                               
            }
        },

        //propiedades computadas
        computed: {
            isActived: function() {
                return this.pagination.current_page;
            },

            //Calcula los elementos de la paginacion
            pagesNumber: function() {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
            },

        },

        methods: {                          
            //Validar que el input solo acepte numeros y punto
            isNumberDecimal: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },

            //Validar que el input solo acepte numeros y punto
            isNumber: function(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57))) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            },

            cambiarPagina(page, buscar, criterio) {
                let me = this;

                //Actualizar la pagina actual
                me.pagination.current_page = page;

                //Envia la peticion para visualizar la data de esa pagina
                me.listarAlumnos(page, buscar, criterio);
            },


            listarInscripcion() {
                let loader = this.$loading.show(this.optionsLoadingOverlay);             
                var me = this;
                var url = 'inscripcion?' + 'idAlumno=' + this.idAlumno;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;

                        if (Array.isArray(respuesta)) { //Tiene inscripcion
                            me.arrayInscripcion = respuesta;
                            //Hacer visible la tabla de Inscripcion
                            me.swMostrarInscripcion = 1;
                            //Ocultar el boton de Agregar Inscripcion
                            me.swModalCursoParalelo = 0;
                        } else { // No tiene incripcion
                            //Hacer visible el boton de Agregar Inscripcion
                            me.swModalCursoParalelo = 1;
                            //Ocultar la tabla de Inscripcion
                            me.swMostrarInscripcion = 0;                   
                        }                                         

                        loader.hide();                        

                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);

                        loader.hide();
                    })
                    .then(function () {
                        // always executed
                    });
            },

            listarAlumnos(page, buscar, criterio) {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
                var url = 'alumno?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;                
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayAlumnos = respuesta.alumnos.data;                        
                        me.pagination = respuesta.pagination;
                        
                        loader.hide();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        
                        loader.hide();
                    })
                    .then(function () {
                        // always executed
                    });
            }, 
    
            listarCursoParalelo(page, buscar, criterio) {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;
                var url = 'cursoParalelo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;                
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayCursoParalelo = respuesta.cursosParalelos.data;                        
                        me.pagination = respuesta.pagination;
                        
                        loader.hide();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                        
                        loader.hide();
                    })
                    .then(function () {
                        // always executed
                    });
            },

            seleccionarAlumno(alumno) {            
                this.idAlumno = alumno.Id;
                this.nombreAlumno = alumno.Nombre;
                this.ciAlumno = alumno.CI;
                this.sexoAlumno = alumno.Sexo;                
                
                this.listarInscripcion();
                this.cerrarModal();
            },

            seleccionarCursoParalelo(cursoParalelo) {
                //console.log(cursoParalelo);
                this.idCursoParalelo = cursoParalelo.Id;                             
                
                this.registrarInscripcion();
                this.cerrarModal();
            },
        
            abrirModal(accion) {
                switch (accion) {
                    case 'alumnos':
                        this.arrayAlumnos = [];                             
                        this.modalAlumno = 1;
                        this.tituloModal = "Seleccione un Alumno";

                        //Llenar array Profesor
                        this.listarAlumnos(1, '', 'Nombre');
                        break;
                                        
                    case 'agregarInscripcion':
                        this.arrayCursoParalelo = [];                             
                        this.modalCursoParalelo = 1;
                        this.tituloModal = "Seleccione un Curso Paralelo";

                        //Llenar array Profesor
                        this.listarCursoParalelo(1, '', 'Nombre');
                        break;
                                        
                    default:
                        break;
                }
                
            },

            cerrarModal() {
                this.modalAlumno = 0;
                this.modalCursoParalelo = 0;
                this.tituloModal = '';                
            },
            
            registrarInscripcion() {                                                
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;                                       

                axios.post(
                    'inscripcion/registrar',
                    {                        
                        'idAlumno': this.idAlumno,
                        'idCursoParalelo': this.idCursoParalelo              
                    }                    
                ).then(function (response) {
                    loader.hide();
                                                                                            
                    me.listarInscripcion();;

                    console.log(response);

                }).catch(function (error) {
                    console.log(error);

                    loader.hide();
                });
            },
                                                    
        },
       
        mounted() {
            //console.log('Component mounted.');                              
        }
    }
    
</script>

<style>
    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3C29297A !important;
    }

    .preview {
        width: 100px;
        background-color: white;
        border: 1px solid #DDD;
        padding: 5px;
    }

    .div-error {
        display: flex;
        justify-content: center;        
    }
    .text-error {
        color: red !important;
        font-weight: bold;
    }

    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
        .btnbuscar {
            margin-top: 2rem;
        }        
        .btnAgregarOferta {
            margin-top: 5px;
        }
    }

</style>