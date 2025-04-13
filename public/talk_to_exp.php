<?php
$api_key_gemini = $_ENV["API_KEY"];
?>
<div class="bg-[#FAF4E6] flex flex-col items-center justify-center w-full p-6">
      <div class="w-full max-w-2xl h-[600px] bg-white rounded-2xl shadow-2xl flex flex-col">
        <div id="chat_box" class="flex-1 overflow-y-auto p-6 text-[#2E2E2E] flex flex-col gap-2"></div>

        <div class="p-4 bg-[#FDFBF7] border-t border-[#E2D9C1] rounded-b-2xl">
          <div class="flex items-center gap-2">
            <input  id="user_input" type="text"
              placeholder="Type your farming question..."
              class="flex-1 p-3 rounded-lg border border-[#D4C8B0] text-[#2E2E2E] placeholder-[#7E7566] focus:outline-none focus:ring-2 focus:ring-[#4CAF50] bg-[#FFFDF9]"
              onkeypress="if(event.key === 'Enter') send_message(event)"
            />
            <button
              onclick="send_message(event)"
              class="px-5 py-3 bg-[#4CAF50] text-white font-semibold rounded-lg hover:bg-[#43A047] transition duration-200"
            >
              Send
            </button>
          </div>
          <div class="flex justify-center mt-4">
            <button
              onclick="recommend_plants()"
              class="px-6 py-2 bg-[#A7D397] text-[#1B3B1A] font-semibold rounded-lg hover:bg-[#94C978] transition duration-200 shadow"
            >
              Plant Picks for Your Weather
            </button>
          </div>
        </div>
      </div>

      <div class="text-center mt-4 text-gray-700 text-sm">
        <p>made by akanksha</p>
        <p>roll no. 37</p>
      </div>

      <script>
        const chat_box = document.getElementById("chat_box");
        const user_input = document.getElementById("user_input");
        const api_key = "<?php echo htmlspecialchars($_ENV['API_KEY']); ?>";
        const model_name = "gemini-1.5-pro";

        window.onload = () => user_input.focus();

        function format_bot_message(raw) {
          raw = raw.replace(
            /\*\*(.*?)\*\*/g,
            '<strong class="block mt-4 text-base text-green-700">$1</strong>'
          );
          raw = raw.replace(
            /\* (.*?)\n/g,
            '<li class="ml-6 list-disc">$1</li>'
          );
          raw = raw.replace(
            /(<li.*?>.*?<\/li>)/gs,
            '<ul class="mt-1 mb-2 text-sm text-[#333]">$1</ul>'
          );
          return raw.replace(/\n/g, "<br>");
        }

        function add_message(message, is_user = false) {
          const message_div = document.createElement("div");
          message_div.classList.add(
            "p-3",
            "rounded-xl",
            "max-w-[70%]",
            "whitespace-pre-wrap",
            "text-sm"
          );

          if (is_user) {
            message_div.classList.add(
              "bg-gray-100",
              "text-[#1B3B1A]",
              "self-end",
              "rounded-lg",
              "px-4",
              "py-2",
              "max-w-[75%]"
            );
            message_div.textContent = `You: ${message}`;
          } else {
            message_div.classList.add(
              "bg-gray-200",
              "text-black",
              "self-start"
            );
            message_div.innerHTML = `<strong> FarmBot:</strong><br>${format_bot_message(
              message
            )}`;
          }

          chat_box.appendChild(message_div);
          chat_box.scrollTop = chat_box.scrollHeight;
        }

        add_message(
          "Hello I'm FarmBot, your farming assistant. Ask me anything related to farming!"
        );

        async function get_gemini_response(prompt) {
          try {
            const response = await fetch(
              `https://generativelanguage.googleapis.com/v1/models/${model_name}:generateContent?key=${api_key}`,
              {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                },
                body: JSON.stringify({
                  contents: [
                    {
                      parts: [
                        {
                          text: `You're a friendly farming assistant. Only answer farming/gardening questions. If irrelevant, reply politely in a helpful tone. If the question is in Hindi, answer in Hindi.\n\n${prompt}`,
                        },
                      ],
                    },
                  ],
                }),
              }
            );

            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            const data = await response.json();
            if (
              data &&
              data.candidates &&
              data.candidates[0] &&
              data.candidates[0].content &&
              data.candidates[0].content.parts &&
              data.candidates[0].content.parts[0]
            ) {
              return data.candidates[0].content.parts[0].text;
            } else {
              return "Sorry, something went wrong.";
            }
          } catch (err) {
            console.error(err);
            return ` Error: ${err.message}`;
          }
        }

        async function send_message(event) {
          event.preventDefault();
          const input = user_input.value.trim();
          if (!input) return;

          add_message(input, true);
          user_input.value = "";

          const response = await get_gemini_response(input);
          add_message(response);
        }

        async function recommend_plants() {
          if (!navigator.geolocation) {
            add_message("Geolocation is not supported by your browser.");
            return;
          }

          navigator.geolocation.getCurrentPosition(async (position) => {
            const { latitude, longitude } = position.coords;

            const currentDate = new Date().toLocaleDateString("en-GB", {
              day: "2-digit",
              month: "long",
              year: "numeric",
            });

            const prompt = `I am at latitude ${latitude} and longitude ${longitude}. The current date is ${currentDate}. Based on this location and date, please recommend the best 3 crops to grow right now. Don;t give uncertain data, or mention that you don't know about it
Be specific about why each crop is suitable based on current weather or climate patterns. Also provide a short description for each crop.`;

            const response = await get_gemini_response(prompt);

            const message_div = document.createElement("div");
            message_div.classList.add(
              "bg-gray-200",
              "text-black",
              "self-start",
              "rounded-xl",
              "px-4",
              "py-3",
              "text-sm",
              "shadow-md"
            );

            const lines = response.split("\n").filter((l) => l.trim());

            const content = response
              .replace(
                /\*\*(.*?)\*\*/g,
                '<strong class="text-green-800 block mt-3 mb-1 text-base">$1</strong>'
              ) 
              .replace(
                /^[-*•]\s+(.*)/gm,
                '<li class="ml-5 list-disc text-sm">$1</li>'
              ) 
              .replace(/(<li.*?>.*?<\/li>)/gs, '<ul class="mt-1 mb-3">$1</ul>') 
              .replace(/\n{2,}/g, "<br><br>") 
              .replace(/\n/g, "<br>"); 

            message_div.innerHTML = `<strong> FarmBot:</strong><br>${content}`;
            chat_box.appendChild(message_div);
            chat_box.scrollTop = chat_box.scrollHeight;
          });
        }
      </script>
    </div>
