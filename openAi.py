import dotenv
from langchain.chat_models import ChatOpenAI
from langchain.chains import ConversationChain
from langchain.document_loaders import WebBaseLoader
from langchain.text_splitter import RecursiveCharacterTextSplitter
from langchain.embeddings import OpenAIEmbeddings
from langchain.vectorstores import Chroma

dotenv.load_dotenv("llm.env")


class llmCall:
    chat = ChatOpenAI()
    conversation = ConversationChain(llm=chat)

    def newprompt(self, prompt):
        nprompt = self.conversation.run(prompt)
        return nprompt

    def fileprocessor(self,file):
        loader = WebBaseLoader("https://lilianweng.github.io/posts/2023-06-23-agent/")
        data = loader.load()
        text_splitter = RecursiveCharacterTextSplitter(chunk_size=500, chunk_overlap=0)
        all_splits = text_splitter.split_documents(data)
        vectorstore = Chroma.from_documents(documents=all_splits, embedding=OpenAIEmbeddings())
        print(vectorstore)