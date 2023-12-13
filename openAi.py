import dotenv
from dotenv import load_dotenv
from langchain.chat_models import ChatOpenAI
from langchain.schema import HumanMessage, SystemMessage
from langchain.chains import ConversationChain

dotenv.load_dotenv("llm.env")


class llmCall:
    chat = ChatOpenAI()
    conversation = ConversationChain(llm=chat)

    def newprompt(self, prompt):
        nprompt = self.conversation.run(prompt)
        return nprompt
