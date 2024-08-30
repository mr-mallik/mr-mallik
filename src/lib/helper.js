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

export function skillIcons(skills, elmItem) {
    const completeSet = [];

    // Create a Map for skill IDs to icons for quick lookup
    const skillMap = new Map(skills.map(skill => [skill.id, skill.icon_pill]));
    const skillsArr = elmItem.skills.split(',').map(skill => skill.trim());

    skillsArr.forEach(skillId => {
        const iconPill = skillMap.get(parseInt(skillId));
        
        if (iconPill) {
            completeSet.push(iconPill);
        }
    });
    
    return completeSet;
}

export function convertToRoman(num) {
    const romanNumeralMap = [
        { value: 1000, symbol: 'M' },
        { value: 900, symbol: 'CM' },
        { value: 500, symbol: 'D' },
        { value: 400, symbol: 'CD' },
        { value: 100, symbol: 'C' },
        { value: 90, symbol: 'XC' },
        { value: 50, symbol: 'L' },
        { value: 40, symbol: 'XL' },
        { value: 10, symbol: 'X' },
        { value: 9, symbol: 'IX' },
        { value: 5, symbol: 'V' },
        { value: 4, symbol: 'IV' },
        { value: 1, symbol: 'I' }
    ];

    let romanNumeral = '';
    for (const { value, symbol } of romanNumeralMap) {
        while (num >= value) {
            romanNumeral += symbol;
            num -= value;
        }
    }

    return romanNumeral;
}

export const skillQuery = `SELECT * 
FROM skills 
ORDER BY 
    CASE 
        WHEN type = 'tech' THEN 1
        WHEN type = 'frame' THEN 2
        WHEN type = 'db' THEN 3
        WHEN type = 'gen' THEN 4
        WHEN type = 'soft' THEN 5
        ELSE 6
    END ASC, 
    rank ASC`;