<template>
  <main class="container">
    <section style="margin-top: 1rem">
      <h1>STORIA E DESCRIZONE</h1>
    </section>

    <section>
      <div class="carousel-container">
        <div class="carousel" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
          <div class="carousel-slide" v-for="(src, index) in images" :key="index">
            <img :src="src" alt="Immagine" />
          </div>
        </div>
      </div>
    </section>

    <section>
      <h2>INTRODUZIONE</h2>
      <p>
        La Basilica di San Giovanni a Porta Latina rappresenta uno degli esempi più significativi e
        meno noti di architettura paleocristiana a Roma. Situata nei pressi della Porta Latina, una
        delle uscite meridionali delle Mura Aureliane, la chiesa offre un’occasione preziosa per
        comprendere l’evoluzione dell’arte sacra e dell’urbanistica cristiana nell’Urbe tardoantica.
      </p>

      <h2>ORIGINI STORICHE</h2>
      <p>
        Secondo la tradizione, la basilica venne costruita tra il 492 e il 496 sotto il pontificato
        di Papa Gelasio I, ma alcuni studiosi suggeriscono che la sua fondazione potrebbe risalire a
        qualche decennio prima. La chiesa sorge in un’area legata alla figura di San Giovanni
        Evangelista, il quale, secondo un’antica leggenda, subì un martirio presso la vicina Porta
        Latina, venendo immerso in una caldaia d’olio bollente senza riportare danni. A
        testimonianza di tale evento, poco distante si trova un piccolo oratorio, San Giovanni in
        Oleo, attribuito a Donato Bramante, costruito nel Quattrocento.
      </p>

      <h2>ARCHITTETURA E CARATTERISTICHE STILISTICHE</h2>
      <p>
        La basilica presenta una pianta a tre navate divise da colonne antiche, probabilmente di
        spoglio, con capitelli di tipo ionico e corinzio. La struttura, in gran parte conservata
        nella sua forma originaria grazie ai restauri del primo Novecento, mantiene l’essenzialità
        dell’architettura paleocristiana: assenza di decorazioni eccessive, uso della luce naturale
        filtrata da piccole finestre, e uno spazio interno pensato più per la contemplazione che per
        la monumentalità. Un elemento distintivo è il soffitto ligneo a cassettoni, decorato in
        epoca successiva ma perfettamente integrato nell’insieme. Degni di nota sono anche i
        frammenti di affreschi absidali risalenti al V-VI secolo, che raffigurano il Cristo in trono
        affiancato da santi: un raro esempio di pittura cristiana delle origini, oggi purtroppo
        molto lacunoso.
      </p>

      <h2>INTERVENTI DI RESTAURO</h2>
      <p>
        Nel corso dei secoli, la basilica ha subito vari interventi di trasformazione, soprattutto
        in epoca medievale e barocca. Tuttavia, tra il 1913 e il 1915, si decise di effettuare un
        restauro radicale, mirato a ripristinare l’aspetto originario della chiesa paleocristiana.
        Le aggiunte successive vennero eliminate, nel rispetto di un’ideologia allora diffusa
        secondo cui il “vero volto” dell’edificio risiedeva nella sua fase più antica. Il risultato
        è un edificio che oggi si presenta sobrio, lineare, ma di grande fascino spirituale e
        storico.
      </p>

      <h2>VALORE ARTISTICO E SIMBOLICO</h2>
      <p>
        Dal punto di vista artistico, San Giovanni a Porta Latina non colpisce per la ricchezza
        decorativa o per l’innovazione formale, quanto per la sua capacità di evocare un tempo
        “altro”, quello della prima cristianità romana. Le colonne antiche riassemblate, i resti di
        pitture murali e la sobrietà architettonica ci parlano di una spiritualità più interiore,
        lontana dalla spettacolarità delle grandi basiliche imperiali. Il sito stesso diventa
        simbolo di resilienza e fede: la leggenda di San Giovanni immerso nell’olio e sopravvissuto
        assume un valore paradigmatico per il cristianesimo delle origini, spesso perseguitato ma
        mai sconfitto.
      </p>
    </section>
  </main>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const images = ref([])

const currentIndex = ref(0)

onMounted(() => {
  fetch('http://localhost:8000/api/about_images.php')
    .then((res) => res.json())
    .then((data) => {
      images.value = data
    })

  setInterval(() => {
    currentIndex.value = (currentIndex.value + 1) % images.value.length
  }, 3000)
})
</script>

<style scoped>
.carousel-container {
  width: 100%;
  margin: auto;
  overflow: hidden;
  padding: 10px; /* spazio intorno al carosello */
  box-sizing: border-box;
}

.carousel {
  display: flex;
  transition: transform 0.5s ease;
}

.carousel-slide {
  flex: 0 0 100%;
  display: flex;
  justify-content: center; /* centra orizzontalmente */
  align-items: center; /* centra verticalmente */
  padding: 10px; /* spazio interno, crea i bordi visivi */
  box-sizing: border-box;
}

.carousel-slide img {
  max-width: 90%; /* lascia margine a sinistra e destra */
  max-height: 300px; /* o altra altezza massima */
  object-fit: contain; /* mantiene le proporzioni e non taglia l'immagine */
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
  background: #fff; /* sfondo bianco per foto verticali con spazio laterale */
}

.text-section h2 {
  font-size: 1.8rem;
  margin-bottom: 1rem;
}

.text-section p {
  font-size: 1rem;
  line-height: 1.6;
  margin-bottom: 1rem;
}
</style>
