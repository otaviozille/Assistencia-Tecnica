import React, { useState } from "react";
import "./Card.css";
import { CircularProgressbar } from "react-circular-progressbar";
import "react-circular-progressbar/dist/styles.css";
import { motion, AnimateSharedLayout } from "framer-motion";
import { UilTimes } from "@iconscout/react-unicons";
import Chart from "react-apexcharts";

// parent Card
const Card = (props) => {
  const [expanded, setExpanded] = useState(false);
  return (
    <AnimateSharedLayout>
      {expanded ? (
        <ExpandedCard param={props} setExpanded={() => setExpanded(false)} />
      ) : (
        <CompactCard param={props} setExpanded={() => setExpanded(true)} />
      )}
    </AnimateSharedLayout>
  );
};

// Compact Card
function CompactCard({ param, setExpanded }) {
  const Png = param.png;
  return (
    <motion.div
      className="CompactCard"
      style={{
        background: param.color.backGround,
        boxShadow: param.color.boxShadow,
      }}
      layoutId="expandableCard"
      onClick={setExpanded}
    >
      <div className="radialBar">
        <CircularProgressbar
          value={param.barValue || 0}
          text={`${param.barValue || 0}%`}
        />
        <span>{param.title}</span>
      </div>
      <div className="detail">
        <Png />
        <span>{param.value}</span>
        
      </div>
    </motion.div>
  );
}

// Expanded Card
function ExpandedCard({ param, setExpanded }) {
  const data = {
    options: {
      chart: {
        type: param.title === "Produtos Vendidos" ? "bar" : "area",
        height: "auto",
      },
      fill: {
        colors: ["#fff"],
        type: "gradient",
      },
      dataLabels: {
        enabled: true, // ✅ Exibe os valores diretamente nas barras
      },
      stroke: {
        curve: "smooth",
        colors: ["white"],
      },
      tooltip: {
        enabled: true,
        x: {
          show: true,
          formatter: function (value, { dataPointIndex }) {
            return param.categories ? param.categories[dataPointIndex] : value; // ✅ Exibe o nome correto ao passar o mouse
          }
        },
        y: {
          formatter: function (value) {
            return `${value} vendas`; // ✅ Exibe "2 vendas" ao passar o mouse
          }
        }
      },
      grid: {
        show: true,
      },
      xaxis: {
        type: "category",
        categories: param.categories || [], // ✅ Agora mostra os nomes corretamente no eixo X
      },
    },
    series: param.series || [{ name: "Produtos", data: [0] }],
  };

  return (
    <motion.div
      className="ExpandedCard"
      style={{
        background: param.color.backGround,
        boxShadow: param.color.boxShadow,
      }}
      layoutId="expandableCard"
    >
      <div style={{ alignSelf: "flex-end", cursor: "pointer", color: "white" }}>
        <UilTimes onClick={setExpanded} />
      </div>
      <span>{param.title}</span>
      <div className="chartContainer">
        <Chart options={data.options} series={data.series} type={param.title === "Produtos Vendidos" ? "bar" : "area"} />
      </div>
      
    </motion.div>
  );
}




export default Card;
