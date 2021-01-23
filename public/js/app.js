function calculateFinalGrade() {
    const grade1 = document.getElementById("grade1").value;
    const grade2 = document.getElementById("grade2").value;
    const grade3 = document.getElementById("grade3").value;

    if (grade1.length > 0 && grade2.length > 0 && grade3 > 0) {
        const sum = (parseFloat(grade1) + parseFloat(grade2) + parseFloat(grade3));
        const finalGrade = (Math.round(parseFloat(sum / 3) * 100) / 100);
        document.getElementById("finalGrade").innerText = finalGrade;
    }
}
