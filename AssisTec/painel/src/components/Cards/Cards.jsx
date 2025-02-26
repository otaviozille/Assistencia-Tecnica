import React from "react";
import "./Cards.css";
import { useCardsData } from "../../Data/Data";
import Card from "../Card/Card";

const Cards = () => {
  const cardsData = useCardsData(); 

  // Verifica se os dados já foram carregados antes de renderizar
  if (!cardsData || cardsData.length === 0) {
    return <p>Carregando gráficos...</p>;
  }

  return (
    <div className="Cards">
      {cardsData.map((card, id) => (
        <div className="parentContainer" key={id}>
          <Card
            title={card.title}
            color={card.color}
            barValue={card.barValue || 0} // Evita erro se for undefined
            value={card.value || "0"} // Evita erro se for undefined
            png={card.png}
            series={card.series || [{ name: "Nenhum dado", data: [0] }]} // Garante que o gráfico não quebre
          />
        </div>
      ))}
    </div>
  );
};

export default Cards;
