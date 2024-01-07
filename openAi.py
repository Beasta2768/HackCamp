import dotenv
from langchain.chat_models import ChatOpenAI
from langchain.chains import ConversationChain, ConversationalRetrievalChain
from langchain.document_loaders import WebBaseLoader
from langchain_community.document_loaders.csv_loader import CSVLoader
from langchain.memory import ConversationSummaryMemory
from langchain.text_splitter import RecursiveCharacterTextSplitter
from langchain.embeddings import OpenAIEmbeddings
from langchain.vectorstores import Chroma
from langchain.load.dump import dumps

from langchain_experimental.agents import create_csv_agent
from langchain.llms import OpenAI
dotenv.load_dotenv("llm.env")


class llmCall:
    chat = ChatOpenAI()
    conversation = ConversationChain(llm=chat)

    def newprompt(self, prompt):
        nprompt = self.conversation.run(prompt)
        return nprompt

    def fileprocessor(self,file,prompt):
        agent = create_csv_agent(OpenAI(temperature=0),
                                 'http://127.0.0.1:5000/files',
                                 verbose=True)
        response = agent.run(prompt)

        if response == "None":
            response = self.conversation.run(prompt)

        return response
