<template>
<div class="container-fluid pl-0 pr-0" v-if="show">
    <nav class="navbar navbar-dark bg-dark d-block mh-10">

            <router-link to="/dashboard">
                <span>Dashboard </span>
            </router-link>

            <router-link to="/dashboard/users">
                <span>Пользователи</span>
            </router-link>

            <router-link to="/">
                <span>Вернуться на главную</span>
            </router-link>



    </nav>

    <div class="row w-100 ml-0 mr-0">
        <aside class="sidebar d-inline-block col-2 text-center">
            <ul v-for='(section_loop,section_name) in sections' :key="section_loop">
                {{ section_name }}
                 <li v-for="element in section_loop " :key="element">
                    <router-link :to="{
                            name: 'section_action',
                            params: {
                                section:section_name,
                                action:element
                            }
                           }">
                        {{ element }}
                    </router-link>
                 </li>
            </ul>

        </aside>

        <div class="dashboard_content d-flex flex-column justify-content-center align-items-center col-10">
            <router-view v-if="$route.path != '/dashboard'"> </router-view>
            <div v-else>
                <span class='lead m-4'> Статистика за месяц :</span>
                <div class="d-flex justify-content-center">
                    <b-badge role="button" variant='success' class="m-2 p-2" @click="renderPlot(sales,'sales')"> Сумма </b-badge>
                    <b-badge role="button" variant='warning' class="m-2 p-2" @click="renderPlot(orders,'quantity')"> Количество </b-badge>
                </div>



                <div id="chart" ref="wrapper">
                </div>

            </div>
        </div>
    </div>


</div>



</template>

<script>
import UsersData from './UsersData';
import UsersUpdate from './UsersUpdate';
import Section from './Section';
import SectionAction from './SectionAction';
const d3 = require('d3')
export default {
    data:function() {
        return {
            sections: {
                departments: ['data','products'],
                products : ['data'],
                dealers : ['data'],
                roles : ['data'],
                workers : ['data','panel'],
                news : ['data'],
            },
            section:  null,
            action : null,
            show : true,
            chartData : null,
            baseWidth : 20,
            orders : '',
            sales : '',
            selectedDate : '',
            selectedPlotSection : 'quantity',
        }
    },
    async mounted() {
        await axios.get('/api/orders').then(res=>this.orders = res.data.reverse())
        await axios.get('/api/sales').then(res=>this.sales = res.data.reverse())
        this.renderPlot(this.orders,'quantity') // по умолчанию рисуем график по кол-ву продаж
    },
    methods : {
        renderPlot(data,yChoice,days) {
            document.getElementById('chart').innerHTML = '' // очищаем график, если он был нарисован

            this.drawPlot(data,yChoice)
        },
        drawPlot(data,yChoice) {
            let margin = {top: 20, right: 20, bottom: 70, left: 40},
            width = 1200 - margin.left - margin.right,
            height = 400 - margin.top - margin.bottom;
            let quantityChoice
            if(yChoice == 'quantity') {
                quantityChoice = true
            } else if(yChoice == 'sales') {
                quantityChoice = false
            }



            // Parse the date / time
            let	parseDate = d3.isoParse
            let a = d3.min(data, d =>  d.created_at)
            let b = d3.max(data, d => d.created_at)
            var x = d3.scaleTime().domain([new Date(b),new Date(a)]).range([0,width]);

            var y = d3.scaleLinear().range([height, 0]);

            var xAxis = d3.axisBottom()
                .scale(x)
                .ticks(data.length)
                //.tickFormat(d3.timeFormat("%d.%m.%y"));

            var yAxis = d3.axisLeft()
                .scale(y)
                .ticks(10);

            var svg = d3.select("#chart").append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
            .append("g")
                .attr("transform",
                    "translate(" + margin.left + "," + margin.top + ")");


                data.forEach(function(d) {
                    d.created_at = d.created_at;
                    if(d.quantity) {
                        d.quantity = d.quantity;
                    } else if(d.sales) {
                        d.sales = d.sales;
                    }
                });
            y.domain([0, d3.max(data, d =>  quantityChoice ? d.quantity : d.sales )]);

            svg.append("g")
                .attr("class", "x axis")
                .attr("transform", "translate(0," + height + ")")
                .call(xAxis.ticks(null).tickSize(0))
                .selectAll("text")
                .style("text-anchor", "middle")

            svg.append("g")
                .attr("class", "y axis")
                .call(yAxis.ticks(null).tickSize(0))
                .append("text")
                .attr("y", 6)
                .style("text-anchor", "middle")
                .text('value');
                let i = 0
            svg.selectAll("bar")
                .data(data)
                .enter().append("rect")
                .style("fill", function(d){ return  '#EF5F67'})
                .text(d=>quantityChoice ? d.quantity : d.sales)
                .attr("x", d => {
                    i++
                    return width - 35.5*i
                })
                .attr("width", 35)
                .attr("y", function(d) { return quantityChoice ? y(d.quantity) : y(d.sales); })
                .attr("height", function(d) {
                    if(quantityChoice) {
                        return height - y(d.quantity)
                    } else {
                        return height - y(d.sales)
                    }
                })
            svg.selectAll("lines")
                .data(data)
                .enter().append("line")
                .style("fill", 'none')
                    .attr("x1", function(d) { return x(d.created_at)  })
                .attr("x2", function(d) { return x(d.created_at); })
            .attr("y1", function(d) { return quantityChoice ? y(d.quantity) : y(d.sales); })
                .attr("y2", function(d) { return quantityChoice ? y(d.quantity) : y(d.sales); })
                    .style("stroke-dasharray", [2,2])
                    .style("stroke", "#000000")
            .style("stroke-width", 2)
            .text(d=>quantityChoice ? d.quantity : d.sales)
        }
    },
    watch : {
        $route : function(to,from) {
            this.show = false;
            this.$nextTick(() => { this.show = true; });
        }
    },
    computed : {
        selectedCategory() {
            if(this.selectedPlotCategory == 'quantity') {
                return this.orders
            } else if(this.selectedPlotCategory == 'sales') {
                return this.sales
            }
        }
    }
}
</script>

<style>
    .axis {
	  font: 10px sans-serif;
	}

	.axis path,
	.axis line {
	  fill: none;
	  stroke: #000;
	  shape-rendering: crispEdges;
	}
    .axis .domain{
      display: none;
    }

    .dashboard_content {
        background: #67d187; /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #7fb1a0, #3ba349); /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #66a0ec, #9df383); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ i 7+ */
    }

    .sidebar {
        height:100vh;
        background: rgb(19, 21, 56);
        border-right: 3px solid rgb(0, 132, 255);
    }

    .sidebar>ul>li {
        list-style-type: none;
        font-size: 18px;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .sidebar>ul {
        color: azure;
    }
</style>
