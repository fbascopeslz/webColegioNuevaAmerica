<template>
    <main class="main">     
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Monitorear Asistencia                    
                </div>

                <div class="card-body">                                                                            
                    <div class="form-row form-group border">
                        <div class="col-md-12 form-group">
                            <label>Seleccione un Alumno: </label>
                        </div>                                                      
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
                                <button @click="abrirModal('alumno')" class="btn btn-primary form control btnbuscar">Seleccionar Alumno</button>                                        
                            </div>                                
                        </div>                                                                                                                                                                                                                                                                                                              
                    </div>

                    <div class="form-row form-group border" v-show="swSeleccionarPeriodo == 1">
                        <div class="col-md-12 form-group">
                            <label>Seleccione un Periodo: </label>
                        </div>                                                      
                        <div class="form-group col-md-3">                                        
                            <label>Descripcion</label>                                                                                  
                            <input type="text" readonly class="form-control" v-model="descripcionPeriodo">                                                                                                                                                                                                                                              
                        </div> 
                        <div class="form-group col-md-3">                                    
                            <label>Año</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="anioPeriodo">                                                                                                                                                                                                                         
                        </div>                        
                        <div class="form-group col-md-2">                                
                            <div class="form-inline">                                                                               
                                <button @click="abrirModal('periodo')" class="btn btn-primary form control btnbuscar">Seleccionar Periodo</button>                                        
                            </div>                                
                        </div>                                                                                                                                                                                                                                                                                                              
                    </div>

                    <div class="form-row form-group border" v-show="swSeleccionarOferta == 1">
                        <div class="col-md-12 form-group">
                            <label>Seleccione una Oferta: </label>
                        </div>                                                      
                        <div class="form-group col-md-6">                                        
                            <label>Materia</label>                                                                                  
                            <input type="text" readonly class="form-control" v-model="materiaOferta">                                                                                                                                                                                                                                              
                        </div> 
                        <div class="form-group col-md-6">                                    
                            <label>Profesor</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="profesorOferta">                                                                                                                                                                                                                         
                        </div>
                        <div class="form-group col-md-4">                                    
                            <label>Curso</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="cursoOferta">                                                                                                                                                                                                                         
                        </div>
                        <div class="form-group col-md-2">                                    
                            <label>Paralelo</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="paraleloOferta">                                                                                                                                                                                                                         
                        </div> 
                        <div class="form-group col-md-6">                                    
                            <label>Nivel</label>                                                                                                                       
                            <input type="text" readonly class="form-control" v-model="nivelOferta">                                                                                                                                                                                                                         
                        </div>                        
                        <div class="form-group col-md-2">                                
                            <div class="form-inline">                                                                               
                                <button @click="abrirModal('oferta')" class="btn btn-primary form control btnbuscar">Seleccionar Oferta</button>                                        
                            </div>                                
                        </div>                                                                                                                                                                                                                                                                                                              
                    </div>

                    <div class="form-row form-group border" v-show="swSeleccionarMes == 1">                                                                        
                        <label class="form-group col-md-3" for="text-input">Seleccione un Mes:</label>
                        <div class="form-group col-md-6">
                            <select class="form-control" v-model="numeroMes">
                                <option v-for="(mes, index) in arrayMeses" :key="index" :value="mes.numeroMes" v-text="mes.mes"></option>                                
                            </select>                            
                        </div>
                        <div class="form-group col-md-3">                                
                            <div class="form-inline">                                                                               
                                <button @click="seleccionarMes()" class="btn btn-primary form control btnbuscar">Seleccionar Mes</button>                                        
                            </div>                                
                        </div>                                                                      
                    </div>

                    <div class="form-row form-group border" v-show="swTablaAsistenciaXDia == 1">                        
                        <div class="form-group table-responsive col-md-12">                    
                            <table class="table table-bordered table-striped table-sm">
                                <thead>                                    
                                    <th v-for="(dia, index) in arrayDia" :key="index" v-text="dia"></th>
                                    <th style="background-color: #FFAF33;" rowspan="2">Asistencias</th>
                                    <th style="background-color: #FFAF33;" rowspan="2">Faltas</th>
                                    <th style="background-color: #FFAF33;" rowspan="2">Retrasos</th>
                                    <th style="background-color: #FFAF33;" rowspan="2">Licencias</th>                                                                                                                                                                                                                                                                                                                                                                                                                         
                                </thead>
                                <tbody>                                    
                                    <td v-for="(numDia, index) in arrayNumeroDia" :key="index" v-text="numDia"></td>
                                    <tr>
                                        <td v-for="(letra, index) in arrayLetraAsistencia" :key="index" v-text="letra"></td>
                                        <td style="background-color: #FFAF33;" v-text="conA"></td>
                                        <td style="background-color: #FFAF33;" v-text="conF"></td>
                                        <td style="background-color: #FFAF33;" v-text="conR"></td>
                                        <td style="background-color: #FFAF33;" v-text="conL"></td>                                                                                                                                                                                                                                                                                                                                                                                                                                                  
                                    </tr>                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <div class="card card-chart">
                                <div class="card-header">
                                    <h4>Grafico de Asistencias</h4>
                                </div>
                                <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="graficoAsistencia">                                                
                                        </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Tipo Asistencia vs Cantidad</p>
                                </div>
                            </div>
                        </div>                     
                    </div>
                                         
                                                         
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>

        <!--Modal para Alumno-->
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
                                    <input type="text" v-model="buscarAlumno" @keyup.enter="listarAlumnos(buscarAlumno, criterioAlumno)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarAlumnos(buscarAlumno, criterioAlumno)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscarAlumno, criterioAlumno, 'alumno')">Ant</a>
                                </li>

                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscarAlumno, criterioAlumno, 'alumno')" v-text="page"></a>
                                </li>       

                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscarAlumno, criterioAlumno, 'alumno')">Sig</a>
                                </li>
                            </ul>
                        </nav>
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

        <!--Modal para Periodo-->
        <div class="modal" tabindex="-1" :class="{'mostrar' : modalPeriodo}" role="dialog" aria-labelledby="myModalLabel" style="display: none; overflow-y: scroll;" aria-hidden="true">
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
                                    <select class="form-control col-md-3" v-model="criterioPeriodo">                                        
                                        <option value="Descripcion">Descripcion</option>                                                                                                                       
                                    </select>
                                    <input type="text" v-model="buscarPeriodo" @keyup.enter="listarPeriodos(buscarPeriodo, criterioPeriodo)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPeriodos(buscarPeriodo, criterioPeriodo)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                <span>(*)Para visualizar todos los Periodos haga una busqueda en blanco</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Año</th>
                                        <th>Descripcion</th>                                        
                                        <th>Fecha Inicio</th>                               
                                        <th>Fecha Fin</th>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(periodo, index) in arrayPeriodos" :key="index">
                                        <td>
                                            <button type="button" @click="seleccionarPeriodo(periodo)" class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i>
                                            </button> 
                                        </td>
                                        <td v-text="periodo.Anio"></td>
                                        <td v-text="periodo.Descripcion"></td>                                        
                                        <td v-text="periodo.FechaInicio"></td>
                                        <td v-text="periodo.FechaFin"></td>                                                                        
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscarPeriodo, criterioPeriodo, 'periodo')">Ant</a>
                                </li>

                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscarPeriodo, criterioPeriodo, 'periodo')" v-text="page"></a>
                                </li>       

                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscarPeriodo, criterioPeriodo, 'periodo')">Sig</a>
                                </li>
                            </ul>
                        </nav>
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

        <!--Modal para Oferta-->
        <div class="modal" tabindex="-1" :class="{'mostrar' : modalOferta}" role="dialog" aria-labelledby="myModalLabel" style="display: none; overflow-y: scroll;" aria-hidden="true">
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
                                    <select class="form-control col-md-3" v-model="criterioOferta">                                        
                                        <option value="Materia.Nombre">Materia</option>                                                                                                                    
                                    </select>
                                    <input type="text" v-model="buscarOferta" @keyup.enter="listarOfertas(buscarOferta, criterioOferta)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarOfertas(buscarOferta, criterioOferta)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                                <span>(*)Para visualizar todas los Ofertas haga una busqueda en blanco</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Profesor</th>
                                        <th>Materia</th>                                        
                                        <th>Curso</th>                               
                                        <th>Paralelo</th>
                                        <th>Nivel</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(oferta, index) in arrayOfertas" :key="index">
                                        <td>
                                            <button type="button" @click="seleccionarOferta(oferta)" class="btn btn-success btn-sm">
                                                <i class="fa fa-check"></i>
                                            </button> 
                                        </td>
                                        <td v-text="oferta.Profesor"></td>
                                        <td v-text="oferta.Materia"></td>                                        
                                        <td v-text="oferta.Curso"></td>
                                        <td v-text="oferta.Paralelo"></td>
                                        <td v-text="oferta.Nivel"></td>                                    
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1, buscarOferta, criterioOferta, 'oferta')">Ant</a>
                                </li>

                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscarOferta, criterioOferta, 'oferta')" v-text="page"></a>
                                </li>       

                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1, buscarOferta, criterioOferta, 'oferta')">Sig</a>
                                </li>
                            </ul>
                        </nav>
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
    import Chart from 'chart.js';

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
                
                idAlumno: 0,
                nombreAlumno: '',                
                ciAlumno: 0,
                sexoAlumno: '',                                                
                arrayAlumnos: [],
                //Para la busqueda en el modal Alumno
                criterioAlumno: 'Nombre',
                buscarAlumno: '',
                modalAlumno: 0,

                idPeriodo: 0,
                descripcionPeriodo: '',                                
                anioPeriodo: '',                                                
                arrayPeriodos: [],
                //Para la busqueda en el modal Periodo
                criterioPeriodo: 'Descripcion',
                buscarPeriodo: '',
                modalPeriodo: 0,
                
                idOferta: 0,
                materiaOferta: '',                                
                profesorOferta: '',
                cursoOferta: '',
                paraleloOferta: '',
                nivelOferta: '',                                           
                arrayOfertas: [],
                //Para la busqueda en el modal Oferta
                criterioOferta: 'Materia.Nombre',
                buscarOferta: '',
                modalOferta: 0,

                //arrays tabla Asistencia
                arrayDia: [],
                arrayNumeroDia: [],
                arrayLetraAsistencia: [],
                conA: 0,
                conF: 0,
                conR: 0,
                conL: 0,

                arrayMeses: [],

                numeroMes: 1,


                //switches
                swSeleccionarPeriodo: 0,
                swSeleccionarOferta: 0,
                swSeleccionarMes: 0,
                swTablaAsistenciaXDia: 0,
                
                tituloModal: '',
                
                            

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

            cambiarPagina(page, buscar, criterio, tipo) {
                let me = this;
                switch (tipo) {
                    case 'alumno':
                        //Actualizar la pagina actual
                        me.pagination.current_page = page;
                        //Envia la peticion para visualizar la data de esa pagina
                        me.listarAlumnos(page, buscar, criterio);
                        break;
                    case 'periodo':
                        //Actualizar la pagina actual
                        me.pagination.current_page = page;
                        //Envia la peticion para visualizar la data de esa pagina
                        me.listarPeriodos(page, buscar, criterio);
                        break;
                    case 'oferta':
                        //Actualizar la pagina actual
                        me.pagination.current_page = page;
                        //Envia la peticion para visualizar la data de esa pagina
                        me.listarOfertas(page, buscar, criterio);
                        break;
                
                    default:
                        break;
                }                                
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

            listarPeriodos(page, buscar, criterio) {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;                
                var url = 'periodo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayPeriodos = respuesta.periodos.data;
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

            listarOfertas(page, buscar, criterio) {
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;                
                var url = 'oferta2?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio + '&idAlumno=' + this.idAlumno;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data;
                        me.arrayOfertas = respuesta.ofertas.data;
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
                //Hacer visible el formulario de seleccionar Periodo
                this.swSeleccionarPeriodo = 1;
                this.cerrarModal();
            },

            seleccionarPeriodo(periodo) {    
                this.idPeriodo = periodo.Id;
                this.descripcionPeriodo = periodo.Descripcion;
                this.anioPeriodo = periodo.Anio;                
                //Hacer visible el formulario de seleccionar Oferta
                this.swSeleccionarOferta = 1;
                this.cerrarModal();

                //llenar el Select de acuerdo al id del Periodo
                this.arrayMeses = [];
                this.llenarSelectMeses();
            },

            llenarSelectMeses() {
                switch (this.idPeriodo) {
                    case 1:
                        this.arrayMeses.push({mes: 'Marzo', numeroMes: 3});
                        this.arrayMeses.push({mes: 'Abril', numeroMes: 4});
                        this.arrayMeses.push({mes: 'Mayo', numeroMes: 5});                     
                        break;
                    case 2:
                        this.arrayMeses.push({mes: 'Junio', numeroMes: 6});
                        this.arrayMeses.push({mes: 'Julio', numeroMes: 7});
                        this.arrayMeses.push({mes: 'Agosto', numeroMes: 8});                        
                        break;
                    case 3:
                        this.arrayMeses.push({mes: 'Septiembre', numeroMes: 9});
                        this.arrayMeses.push({mes: 'Octubre', numeroMes: 10});
                        this.arrayMeses.push({mes: 'Noviembre', numeroMes: 11});                       
                        break;                
                    default:
                        break;
                }
            },

            seleccionarOferta(oferta) {
                this.idOferta = oferta.Id;
                this.materiaOferta = oferta.Materia;
                this.profesorOferta = oferta.Profesor;
                this.cursoOferta = oferta.Curso;
                this.paraleloOferta = oferta.Paralelo;
                this.nivelOferta = oferta.Nivel;
                //Hacer visible el formulario de seleccionar Oferta
                this.swSeleccionarMes = 1;
                this.cerrarModal();
            },
        
            abrirModal(accion) {
                //resetear la paginacion
                this.pagination = {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0,
                };

                switch (accion) {
                    case 'alumno':
                        this.arrayAlumnos = [];                             
                        this.modalAlumno = 1;
                        this.tituloModal = "Seleccione un Alumno";
                        //Llenar array Alumno
                        this.listarAlumnos(1, this.buscarAlumno, this.criterioAlumno); 
                        break;                        
                    case 'periodo':
                        this.arrayPeriodos = [];                             
                        this.modalPeriodo = 1;
                        this.tituloModal = "Seleccione un Periodo";
                        //Llenar array Alumno
                        this.listarPeriodos(1, this.buscarPeriodo, this.criterioPeriodo); 
                        break;
                    case 'oferta':
                        this.arrayOfertas = [];                             
                        this.modalOferta = 1;
                        this.tituloModal = "Seleccione una Oferta";
                        //Llenar array Alumno
                        this.listarOfertas(1, this.buscarOferta, this.criterioOferta); 
                        break;
                
                    default:
                        break;
                }
                
            },

            cerrarModal() {
                this.modalAlumno = 0;
                this.modalPeriodo = 0;
                this.modalOferta = 0;
                this.tituloModal = '';                
            },


            
            getTablaAsistencia() {           
                let loader = this.$loading.show(this.optionsLoadingOverlay);
                let me = this;                
                var url = 'monitorearAsistencia/getTablaAsistencia?'+ 
                    'idAlumno=' + this.idAlumno + '&idOferta=' + this.idOferta + '&idPeriodo=' + this.idPeriodo + '&numeroMes=' + this.numeroMes;
                
                axios.get(url)
                    .then(function (response) {
                        // handle success
                        console.log(response);

                        var respuesta = response.data.asistencia;                                            
                        respuesta.forEach(element => {
                            me.arrayDia.push(me.diaEnInglesToEspaniol(element.diaSemana));
                            me.arrayNumeroDia.push(element.dia);
                            me.arrayLetraAsistencia.push(element.letra);
                            
                            switch (element.letra) {
                                case "A":
                                    me.conA = me.conA + 1;
                                    break;
                                case "F":
                                    me.conF = me.conF + 1;
                                    break;
                                case "R":
                                    me.conR = me.conR + 1;
                                    break;
                                case "L":
                                    me.conL = me.conL + 1;
                                    break;                            
                                default:
                                    break;
                            }
                        });
                        me.cargarGraficaTotalAsistencias();                        

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

            diaEnInglesToEspaniol(mesEnIngles) {
                switch (mesEnIngles) {
                    case 'Monday':
                        return "Lunes";
                    case 'Tuesday':
                        return "Martes";
                    case 'Wednesday':
                        return "Miercoles";
                    case 'Thursday':
                        return "Jueves";
                    case 'Friday':
                        return "Viernes";                                    
                    default:
                        return mesEnIngles;
                }
            },

            seleccionarMes() {
                this.swTablaAsistenciaXDia = 1;
                this.getTablaAsistencia();
            },

            cargarGraficaTotalAsistencias() {                                
                var ctx = document.getElementById('graficoAsistencia').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ["Asistencia", "Falta", "Retraso", "Licencia"],
                        datasets: [{
                            label: 'Tipo de Asistencia',
                            data: [this.conA, this.conF, this.conR, this.conL],
                            backgroundColor: ['rgba(0, 128, 0, 0.8)', 'rgba(255, 0, 0, 0.8)', 'rgba(255, 255, 0, 0.8)', 'rgba(0, 0, 255, 0.8)'],
                            borderColor: ['rgba(0, 128, 0, 0.8)', 'rgba(255, 0, 0, 0.8)', 'rgba(255, 255, 0, 0.8)', 'rgba(0, 0, 255, 0.8)'],
                            borderWidth: 5
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
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