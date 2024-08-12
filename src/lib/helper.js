export function calculateDateDifference(startDate, endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);
    
    let years = end.getFullYear() - start.getFullYear();
    let months = end.getMonth() - start.getMonth();
    
    // If the end day is before the start day, subtract one month
    if (end.getDate() < start.getDate()) {
        months--;
    }
    
    // Adjust years if months are negative
    if (months < 0) {
        years--;
        months += 12;
    }
    
    // Include the start and end months
    const totalMonths = (years * 12) + months + 1; // +1 to include the end month
    
    // Calculate years and months from total months
    years = Math.floor(totalMonths / 12);
    months = totalMonths % 12;

    return `${years > 0 ? `${years} Year${years > 1 ? 's' : ''}` : ''} ${months > 0 ? `${months} Month${months > 1 ? 's' : ''}` : ''}`.trim();
}