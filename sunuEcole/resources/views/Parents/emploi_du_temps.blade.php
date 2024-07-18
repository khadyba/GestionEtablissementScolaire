<!DOCTYPE html>
<html>
<head>
    <title>Emploi du Temps</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
</head>
<body>
    <h1>Emploi du Temps de {{ $eleve->prenoms }} {{ $eleve->nom }}</h1>
    <table>
        <!-- Ajoutez ici votre table d'emploi du temps -->
    </table>
    <button onclick="downloadPDF()">Télécharger en PDF</button>

    <script>
        function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            doc.text("Emploi du Temps de {{ $eleve->prenoms }} {{ $eleve->nom }}", 10, 10);
            // Ajouter le contenu du tableau à votre PDF ici
            doc.save("emploi_du_temps.pdf");
        }
    </script>
</body>
</html>
