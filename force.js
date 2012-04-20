var width = 960,
    height = 800;

var color = d3.scale.category20();

var force = d3.layout.force()
    .charge(node_charge)
    .linkDistance(edge_length)
    .size([width, height]);

var svg = d3.select("#chart").append("svg")
    .attr("width", width)
    .attr("height", height);

d3.json(json_data, function(json) {
    force
	.nodes(json.nodes)
	.links(json.links)
	.start();

    var link = svg.selectAll("line.link")
	.data(json.links)
	.enter().append("line")
	.attr("class", "link")
	.style("stroke-width", 1);

    var node = svg.selectAll("circle.node")
	.data(json.nodes)
	.enter().append("circle")
	.attr("class", "node")
	.attr("r", function(d) {return 3+Math.log(d.weight); })
        .style("fill", function(d) { return d.sex==1? "#aec7e8":"#ff9896"; })
	.call(force.drag);
    
    node.append("title")
	  .text(function(d) { return d.name; });

    force.on("tick", function() {

	link.attr("x1", function(d) { return xinwindow(d.source.x); })
            .attr("y1", function(d) { return yinwindow(d.source.y); })
            .attr("x2", function(d) { return xinwindow(d.target.x); })
            .attr("y2", function(d) { return yinwindow(d.target.y); });

	node.attr("cx", function(d) { return xinwindow(d.x); })
            .attr("cy", function(d) { return yinwindow(d.y); });
    });
});

function xinwindow(x) {if (x > width) return width; else if (x < 0)  return 0; else return x;}
function yinwindow(y) {if (y > height) return height; else if (y < 0) return 0; else return y;}
