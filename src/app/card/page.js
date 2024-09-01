/* const NFCWriter = () => {
  const handleNFCShare = async () => {
    // Check if the NDEFReader is available in the current browser
    if ('NDEFReader' in window) {
      try {
        const ndef = new NDEFReader(); // Create a new NDEFReader instance
        await ndef.write({
          records: [
            {
              recordType: 'text',
              data: 'BEGIN:VCARD\nVERSION:3.0\nFN:John Doe\nTEL:+1234567890\nEMAIL:john.doe@example.com\nEND:VCARD',
            },
          ],
        });

        console.log('Contact details have been written to the NFC tag!');
        alert('Contact details shared successfully!');
      } catch (error) {
        console.error('Error writing to NFC tag:', error);
        alert('Failed to share contact details via NFC.');
      }
    } else {
      console.warn('Web NFC is not supported in this browser.');
      alert('NFC sharing is not supported on this device.');
    }
  };

  return (
    <div>
      <button onClick={handleNFCShare}>Share Contact via NFC</button>
    </div>
  );
};

export default NFCWriter; */


import React from "react";

const Card =  () => {
    return (
        <div className="flex items-center justify-center min-h-screen bg-black">
            <div className="max-w-xs bg-white rounded-lg shadow-lg overflow-hidden">
                <div className="h-48 bg-cover bg-center" style={{backgroundImage: "url('https://via.placeholder.com/300x400')" }} ></div>

                <div className="p-4">
                    <h2 className="text-2xl font-bold text-gray-800">John Doe</h2>
                    <p className="text-sm text-gray-600 mt-2">Software Developer</p>
                    
                    <div className="mt-4">
                        <p className="text-sm text-gray-500">Phone: +123 456 7890</p>
                        <p className="text-sm text-gray-500">Email: john.doe@example.com</p>
                        <p className="text-sm text-gray-500">Website: www.johndoe.com</p>
                    </div>

                    <div className="mt-4 flex space-x-4">
                        <a href="#" className="text-gray-500 hover:text-gray-800">Li</a>
                    </div>

                    <div className="mt-6 flex space-x-4">
                        <button className="flex-1 bg-blue-500 text-white py-2 rounded-lg shadow hover:bg-blue-600" >
                            Share via NFC
                        </button>
                        <button className="flex-1 bg-green-500 text-white py-2 rounded-lg shadow hover:bg-green-600" >
                            Share via QR Code
                        </button>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default Card;